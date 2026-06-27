<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePaymentRequest;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function create(Invoice $invoice)
    {
        if ($invoice->status !== 'unpaid') {
            abort(403);
        }

        if ($invoice->payment) {
            abort(403);
        }

        return view(
            'admin.payments.create',
            compact('invoice')
        );
    }

    public function store(StorePaymentRequest $request,Invoice $invoice)
    {
        if ($invoice->status !== 'unpaid') {
            abort(403);
        }

        if ((float) $request->amount !== (float) $invoice->total_amount) {
            return back()
                ->withErrors([
                    'amount' => 'Payment amount must match invoice total.'
                ])
                ->withInput();
        }

        if ($invoice->payment) {
            abort(403);
        }

        DB::transaction(function () use (
            $request,
            $invoice
        ) {

            Payment::create([
                'payment_number' =>
                    'PAY-' .
                    now()->format('YmdHis').'-'. random_int(100, 999),

                'invoice_id' => $invoice->id,

                'payment_method' => $request->payment_method,

                'amount' => $request->amount,

                'paid_at' => now(),

                'status' => 'paid',

                'paid_by' => Auth::id(),

                'confirmed_by' => Auth::id(),

                'confirmed_at' => now(),

                'notes' => $request->notes,
            ]);

            $invoice->update([
                'status' => 'paid',
            ]);
        });

        activity()
            ->causedBy(Auth::user())
            ->performedOn($invoice)
            ->event('payment_created')
            ->log('Payment created');

        return redirect()
            ->route('admin.invoices.show', $invoice)
            ->with(
                'success',
                'Payment created successfully.'
            );
    }
}
