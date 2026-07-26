<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateInvoiceDiscountRequest;
use App\Http\Requests\UpdateInvoiceTaxRequest;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            return DataTables::of(
                Invoice::with([
                    'registration.patient',
                    'payment',
                ])
            )

                ->addIndexColumn()

                ->addColumn('patient_name', function ($invoice) {

                    return $invoice
                        ->registration
                        ?->patient
                        ?->name ?? '-';

                })

                ->editColumn('total_amount', function ($invoice) {

                    return 'Rp '.number_format(
                        $invoice->total_amount,
                        0,
                        ',',
                        '.'
                    );

                })

                ->editColumn('status', function ($invoice) {

                    return match ($invoice->status) {

                        'unpaid' => '
                            <span class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">
                                Unpaid
                            </span>
                        ',

                        'paid' => '
                            <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                Paid
                            </span>
                        ',

                        'cancelled' => '
                            <span class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                Cancelled
                            </span>
                        ',

                        'refunded' => '
                            <span class="inline-flex items-center rounded-full bg-orange-100 px-3 py-1 text-xs font-semibold text-orange-700">
                                Refunded
                            </span>
                        ',

                        default => '
                            <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                                -
                            </span>
                        ',
                    };

                })

                ->addColumn('payment_status', function ($invoice) {

                    if (! $invoice->payment) {

                        return '
                            <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                                -
                            </span>
                        ';

                    }

                    return match ($invoice->payment->status) {

                        'pending' => '
                            <span class="inline-flex items-center rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">
                                Pending
                            </span>
                        ',

                        'paid' => '
                            <span class="inline-flex items-center rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                Paid
                            </span>
                        ',

                        'failed' => '
                            <span class="inline-flex items-center rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                Failed
                            </span>
                        ',

                        'cancelled' => '
                            <span class="inline-flex items-center rounded-full bg-slate-200 px-3 py-1 text-xs font-semibold text-slate-700">
                                Cancelled
                            </span>
                        ',

                        default => '
                            <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                                -
                            </span>
                        ',
                    };

                })

                ->addColumn('action', function ($invoice) {

                    $buttons = '

                        <div class="flex items-center gap-2 whitespace-nowrap">

                            <a
                                href="'.route(
                                    'admin.invoices.show',
                                    $invoice
                                ).'"

                                class="
                                    inline-flex
                                    items-center

                                    rounded-lg

                                    bg-blue-50
                                    px-3
                                    py-2

                                    text-xs
                                    font-semibold
                                    text-blue-700

                                    transition

                                    hover:bg-blue-100
                                "
                            >
                                View
                            </a>

                    ';

                    if ($invoice->isEditable()) {

                        $buttons .= '

                            <a
                                href="'.route(
                                    'admin.payments.create',
                                    $invoice
                                ).'"

                                class="
                                    inline-flex
                                    items-center

                                    rounded-lg

                                    bg-emerald-50
                                    px-3
                                    py-2

                                    text-xs
                                    font-semibold
                                    text-emerald-700

                                    transition

                                    hover:bg-emerald-100
                                "
                            >
                                Pay
                            </a>

                        ';

                        $buttons .= '

                            <form
                                method="POST"
                                action="'.route(
                                    'admin.invoices.cancel',
                                    $invoice
                                ).'"
                            >

                                '.csrf_field().'
                                '.method_field('PATCH').'

                                <button
                                    type="submit"

                                    class="
                                        inline-flex
                                        items-center

                                        rounded-lg

                                        bg-red-50
                                        px-3
                                        py-2

                                        text-xs
                                        font-semibold
                                        text-red-700

                                        transition

                                        hover:bg-red-100
                                    "
                                >
                                    Cancel
                                </button>

                            </form>

                        ';

                    }

                    $buttons .= '</div>';

                    return $buttons;

                })

                ->rawColumns([
                    'status',
                    'payment_status',
                    'action',
                ])

                ->make(true);

        }

        return view('admin.invoices.index');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load([
            'registration.patient',
            'items',
            'payment',
        ]);
        
        return view(
            'admin.invoices.show',
            compact('invoice')
        );
    }

    public function cancel(Invoice $invoice)
    {
        if (! $invoice->isEditable()) {
            abort(403);
        }

        $invoice->update([
            'status' => 'cancelled',
        ]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($invoice)
            ->event('cancelled')
            ->log('Invoice cancelled');

        return back()->with(
            'success',
            'Invoice cancelled successfully.'
        );
    }

    public function updateDiscount(UpdateInvoiceDiscountRequest $request, Invoice $invoice)
    {
        if (! $invoice->isEditable()) {
            abort(403);
        }

        $subtotal = $invoice->subtotal_amount;

        $discount = $request->discount_amount;

        $total =
            $subtotal
            - $discount
            + $invoice->tax_amount;

        $invoice->update([
            'discount_amount' => $discount,
            'total_amount' => max($total, 0),
        ]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($invoice)
            ->event('discount_updated')
            ->log('Invoice discount updated');

        return back()->with(
            'success',
            'Discount updated successfully.'
        );
    }

    public function updateTax(UpdateInvoiceTaxRequest $request, Invoice $invoice)
    {
        if (! $invoice->isEditable()) {
            abort(403);
        }

        $subtotal = $invoice->subtotal_amount;

        $tax = $request->tax_amount;

        $total =
            $subtotal
            - $invoice->discount_amount
            + $tax;

        $invoice->update([
            'tax_amount' => $tax,
            'total_amount' => max($total, 0),
        ]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($invoice)
            ->event('tax_updated')
            ->log('Invoice tax updated');

        return back()->with(
            'success',
            'Tax updated successfully.'
        );
    }
}
