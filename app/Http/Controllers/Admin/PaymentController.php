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

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $currentShift = $user
            ->cashierShifts()
            ->where('status', 'open')
            ->latest()
            ->first();

        return view(
            'admin.payments.create',
            compact('invoice', 'currentShift')
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

        $isCash = $request->payment_method === 'cash';

        $currentShift = null;

        if ($isCash) {

            /** @var \App\Models\User $user */
            $user = Auth::user();

            $currentShift = $user
                ->cashierShifts()
                ->where('status', 'open')
                ->latest()
                ->first();

            if (! $currentShift) {
                return back()
                    ->withErrors([
                        'payment' => 'Please open a cashier shift before accepting cash payments.',
                    ])
                    ->withInput();
            }
        }

        DB::transaction(function () use (
            $request,
            $invoice,
            $paymentProof,
            $currentShift,
            $isCash
        ) {

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

                'cashier_shift_id' => $currentShift?->id,
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

            $currentShift = $payment
                ->cashier
                ?->cashierShifts()
                ->where('status','open')
                ->latest()
                ->first();

            $payment->update([
                'status' => 'paid',
                'confirmed_by' => Auth::id(),
                'confirmed_at' => now(),
                'cashier_shift_id' => $currentShift?->id,
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

    public function refund(Payment $payment)
    {
        if ($payment->status !== 'paid') {
            abort(403);
        }

        DB::transaction(function () use ($payment) {

            $payment->update([

                'status' => 'cancelled',

                'refunded_by' => Auth::id(),

                'refunded_at' => now(),

            ]);

            $payment->invoice->update([

                'status' => 'unpaid',

            ]);

        });

        activity()
            ->causedBy(Auth::user())
            ->performedOn($payment)
            ->event('payment_refunded')
            ->log('Payment refunded');

        return redirect()
            ->route('admin.invoices.show', $payment->invoice)
            ->with(
                'success',
                'Payment refunded successfully.'
            );
    }
}
