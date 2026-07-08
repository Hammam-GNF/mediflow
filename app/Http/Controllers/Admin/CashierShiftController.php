<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CashierShift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CashierShiftController extends Controller
{
    public function index()
    {
        $currentShift = CashierShift::where(
            'user_id',
            Auth::id()
        )
        ->where(
            'status',
            'open'
        )
        ->latest()
        ->first();

        return view(
            'admin.cashier-shifts.index',
            [
                'currentShift' => $currentShift,
                'shifts' => CashierShift::with('cashier')
                    ->latest()
                    ->paginate(15),
            ]
        );
    }

    public function close(Request $request, CashierShift $cashierShift)
    {
        abort_if(
            $cashierShift->status === 'closed',
            403
        );

        $request->validate([
            'closing_balance' => [
                'required',
                'numeric',
                'min:0',
            ],
            'notes' => [
                'nullable',
                'string',
            ],
        ]);

        DB::transaction(function () use (
            $cashierShift,
            $request
        ) {

            $expectedBalance =
                $cashierShift->expected_closing_balance;

            $difference =
                $request->closing_balance
                - $expectedBalance;

            $cashierShift->update([

                'closing_balance' =>
                    $request->closing_balance,

                'difference_amount' => $difference,

                'closed_at' => now(),

                'status' => 'closed',

                'notes' => $request->notes,

            ]);

        });

        activity()
            ->causedBy(Auth::user())
            ->performedOn($cashierShift)
            ->event('cashier_shift_closed')
            ->log('Cashier shift closed');

        return back()->with(
            'success',
            'Cashier shift closed successfully.'
        );
    }

    public function open(Request $request)
    {
        $request->validate([
            'opening_balance' => [
                'required',
                'numeric',
                'min:0',
            ],
            'notes' => [
                'nullable',
                'string',
            ],
        ]);

        $user = Auth::user();

        $hasOpenShift = CashierShift::where(
            'user_id',
            $user->id
        )
        ->where(
            'status',
            'open'
        )
        ->exists();

        if ($hasOpenShift) {
            return back()->withErrors([
                'shift' => 'You already have an open cashier shift.',
            ]);
        }

        $shift = CashierShift::create([
            'user_id' => $user->id,
            'opened_at' => now(),
            'opening_balance' => $request->opening_balance,
            'notes' => $request->notes,
        ]);

        activity()
            ->causedBy($user)
            ->performedOn($shift)
            ->event('cashier_shift_opened')
            ->log('Cashier shift opened');

        return back()->with(
            'success',
            'Cashier shift opened successfully.'
        );
    }

    public function show(CashierShift $cashierShift)
    {
        $cashierShift->load([
            'cashier',
            'payments.invoice.registration.patient',
        ]);

        return view(
            'admin.cashier-shifts.show',
            compact('cashierShift')
        );
    }
}