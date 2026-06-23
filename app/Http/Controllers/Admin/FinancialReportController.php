<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class FinancialReportController extends Controller
{
    public function index(Request $request)
    {
        $payments = Payment::with([
            'invoice.registration.patient'
        ])

        ->when(
            $request->start_date,
            fn ($query) =>
                $query->whereDate(
                    'paid_at',
                    '>=',
                    $request->start_date
                )
        )

        ->when(
            $request->end_date,
            fn ($query) =>
                $query->whereDate(
                    'paid_at',
                    '<=',
                    $request->end_date
                )
        )

        ->latest('paid_at')
        ->get();

        return view(
            'admin.reports.financial.index',
            [
                'payments' => $payments,
                'totalRevenue' => $payments->sum('amount'),
                'totalTransactions' => $payments->count(),
            ]
        );
    }

    public function pdf(Request $request)
    {
        $payments = Payment::with([
            'invoice.registration.patient'
        ])

        ->when(
            $request->start_date,
            fn ($query) =>
                $query->whereDate(
                    'paid_at',
                    '>=',
                    $request->start_date
                )
        )

        ->when(
            $request->end_date,
            fn ($query) =>
                $query->whereDate(
                    'paid_at',
                    '<=',
                    $request->end_date
                )
        )

        ->latest('paid_at')
        ->get();

        $pdf = Pdf::loadView(
            'admin.reports.financial.pdf',
            [
                'payments' => $payments,
                'totalRevenue' => $payments->sum('amount'),
            ]
        );

        return $pdf->download(
            'financial-report.pdf'
        );
    }
}