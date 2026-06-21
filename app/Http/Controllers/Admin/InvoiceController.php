<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
                    'registration.patient'
                ])
            )
            ->addIndexColumn()

            ->addColumn(
                'patient_name',
                fn ($invoice)
                    =>
                    $invoice
                        ->registration
                        ->patient
                        ->name
            )

            ->editColumn(
                'total_amount',
                fn ($invoice)
                    =>
                    number_format(
                        $invoice->total_amount
                    )
            )

            ->addColumn('action', function ($invoice) {

                $buttons = '
                    <div class="flex gap-2">
                ';

                $buttons .= '
                    <a
                        href="' . route(
                            'admin.invoices.show',
                            $invoice
                        ) . '"
                        class="px-3 py-1 bg-blue-600 text-white rounded"
                    >
                        View
                    </a>
                ';

                if ($invoice->status === 'pending') {

                    $buttons .= '
                        <form
                            action="' . route(
                                'admin.invoices.paid',
                                $invoice
                            ) . '"
                            method="POST"
                        >
                            ' . csrf_field() . '
                            ' . method_field('PATCH') . '

                            <button
                                type="submit"
                                class="px-3 py-1 bg-green-600 text-white rounded"
                            >
                                Paid
                            </button>
                        </form>
                    ';

                    $buttons .= '
                        <form
                            action="' . route(
                                'admin.invoices.cancel',
                                $invoice
                            ) . '"
                            method="POST"
                        >
                            ' . csrf_field() . '
                            ' . method_field('PATCH') . '

                            <button
                                type="submit"
                                class="px-3 py-1 bg-red-600 text-white rounded"
                            >
                                Cancel
                            </button>
                        </form>
                    ';
                }

                $buttons .= '</div>';

                return $buttons;
            })

            ->rawColumns(['action'])
            ->make(true);
        }

        return view(
            'admin.invoices.index'
        );
    }

    public function show(Invoice $invoice)
    {
        return view(
            'admin.invoices.show',
            compact('invoice')
        );
    }

    public function markAsPaid(Invoice $invoice)
    {
        $invoice->update([
            'status' => 'paid',
        ]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($invoice)
            ->event('paid')
            ->log('Invoice paid');

        return back()->with(
            'success',
            'Invoice paid successfully.'
        );
    }

    public function cancel(Invoice $invoice)
    {
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
}
