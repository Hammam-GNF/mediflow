<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CashierShift;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CashierShiftReportExport;

class CashierShiftReportController extends Controller
{
    public function index(Request $request)
    {
        $query = CashierShift::with([
            'cashier',
            'payments',
        ]);

        if ($request->filled('start_date')) {
            $query->whereDate(
                'opened_at',
                '>=',
                $request->start_date
            );
        }

        if ($request->filled('end_date')) {
            $query->whereDate(
                'opened_at',
                '<=',
                $request->end_date
            );
        }

        if ($request->filled('cashier_id')) {
            $query->where(
                'user_id',
                $request->cashier_id
            );
        }

        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->status
            );
        }

        $shifts = $query
            ->latest('opened_at')
            ->get();

        return view(
            'admin.reports.cashier-shifts.index',
            [
                'shifts' => $shifts,

                'cashiers' => User::role('cashier')
                    ->orderBy('name')
                    ->get(),

                'totalShifts' => $shifts->count(),

                'openShifts' => $shifts
                    ->where('status', 'open')
                    ->count(),

                'closedShifts' => $shifts
                    ->where('status', 'closed')
                    ->count(),

                'totalRevenue' => $shifts
                    ->sum('revenue'),

                'totalOpeningBalance' => $shifts
                    ->sum('opening_balance'),

                'totalExpectedClosing' => $shifts
                    ->sum('expected_closing_balance'),

                'totalClosingBalance' => $shifts
                    ->where('status', 'closed')
                    ->sum('closing_balance'),

                'totalDifference' => $shifts
                    ->where('status', 'closed')
                    ->sum('difference_amount'),
            ]
        );
    }

    public function pdf(Request $request)
    {
        $query = CashierShift::with([
            'cashier',
            'payments',
        ]);

        if ($request->filled('start_date')) {
            $query->whereDate(
                'opened_at',
                '>=',
                $request->start_date
            );
        }

        if ($request->filled('end_date')) {
            $query->whereDate(
                'opened_at',
                '<=',
                $request->end_date
            );
        }

        if ($request->filled('cashier_id')) {
            $query->where(
                'user_id',
                $request->cashier_id
            );
        }

        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->status
            );
        }

        $shifts = $query
            ->latest('opened_at')
            ->get();

        $pdf = Pdf::loadView(
            'admin.reports.cashier-shifts.pdf',
            [
                'shifts' => $shifts,

                'totalRevenue' => $shifts->sum('revenue'),

                'totalDifference' => $shifts
                    ->where('status', 'closed')
                    ->sum('difference_amount'),

                'totalShifts' => $shifts->count(),
            ]
        );

        return $pdf->download(
            'cashier-shift-report.pdf'
        );
    }

    public function export(Request $request)
    {
        return Excel::download(
            new CashierShiftReportExport($request),
            'cashier-shift-report.xlsx'
        );
    }
}