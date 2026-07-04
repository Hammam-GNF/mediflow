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

    public function store(StorePaymentRequest $request, Invoice $invoice)
    {
        if (! $invoice->isEditable()) {
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

        $paymentProof = null;

        if ($request->hasFile('payment_proof')) {
            $paymentProof = $request
                ->file('payment_proof')
                ->store('payment-proofs', 'public');
        }

        DB::transaction(function () use (
            $request,
            $invoice,
            $paymentProof
        ) {

            $isCash = $request->payment_method === 'cash';

            Payment::create([
                'payment_number' =>
                    'PAY-'
                    . now()->format('YmdHis')
                    . '-'
                    . random_int(100,999),

                'invoice_id' => $invoice->id,

                'payment_method' => $request->payment_method,

                'amount' => $request->amount,

                'paid_at' => now(),

                'status' => $isCash
                    ? 'paid'
                    : 'pending',

                'paid_by' => Auth::id(),

                'confirmed_by' => $isCash
                    ? Auth::id()
                    : null,

                'confirmed_at' => $isCash
                    ? now()
                    : null,

                'payment_reference' => $request->payment_reference,

                'payment_proof' => $paymentProof,

                'notes' => $request->notes,
            ]);

            if ($isCash) {

                $invoice->update([
                    'status' => 'paid',
                ]);
            }
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
                $request->payment_method === 'cash'
                    ? 'Payment completed successfully.'
                    : 'Payment submitted and waiting for confirmation.'
            );
    }

    public function approve(Payment $payment)
    {
        if ($payment->status !== 'pending') {
            abort(403);
        }

        DB::transaction(function () use ($payment) {

            $payment->update([
                'status' => 'paid',
                'confirmed_by' => Auth::id(),
                'confirmed_at' => now(),
            ]);

            $payment->invoice->update([
                'status' => 'paid',
            ]);
        });

        activity()
            ->causedBy(Auth::user())
            ->performedOn($payment)
            ->event('payment_approved')
            ->log('Payment approved');

        return redirect()
            ->route('admin.invoices.show', $payment->invoice)
            ->with(
                'success',
                'Payment approved successfully.'
            );
    }

    public function reject(Payment $payment)
    {
        if ($payment->status !== 'pending') {
            abort(403);
        }

        DB::transaction(function () use ($payment) {

            $payment->update([
                'status' => 'failed',
                'confirmed_by' => Auth::id(),
                'confirmed_at' => now(),
            ]);

            $payment->invoice->update([
                'status' => 'unpaid',
            ]);
        });

        activity()
            ->causedBy(Auth::user())
            ->performedOn($payment)
            ->event('payment_rejected')
            ->log('Payment rejected');

        return redirect()
            ->route('admin.invoices.show', $payment->invoice)
            ->with(
                'success',
                'Payment rejected.'
            );
    }
}
