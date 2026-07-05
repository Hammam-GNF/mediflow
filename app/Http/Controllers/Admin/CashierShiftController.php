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
        return view(
            'admin.cashier-shifts.index',
            [
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

            $cashierShift->update([

                'closing_balance' =>
                    $request->closing_balance,

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
}