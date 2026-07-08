<?php

namespace App\Exports;

use App\Models\CashierShift;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Facades\Excel;

class CashierShiftReportExport implements
    FromCollection,
    WithHeadings,
    ShouldAutoSize
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = CashierShift::with([
            'cashier',
            'payments',
        ]);

        if ($this->request->filled('start_date')) {

            $query->whereDate(
                'opened_at',
                '>=',
                $this->request->start_date
            );

        }

        if ($this->request->filled('end_date')) {

            $query->whereDate(
                'opened_at',
                '<=',
                $this->request->end_date
            );

        }

        if ($this->request->filled('cashier_id')) {

            $query->where(
                'user_id',
                $this->request->cashier_id
            );

        }

        if ($this->request->filled('status')) {

            $query->where(
                'status',
                $this->request->status
            );

        }

        return $query
            ->latest('opened_at')
            ->get()
            ->map(function ($shift) {

                return [

                    'cashier' =>
                        $shift->cashier?->name,

                    'opened_at' =>
                        $shift->opened_at?->format('d-m-Y H:i'),

                    'closed_at' =>
                        $shift->closed_at
                            ? $shift->closed_at->format('d-m-Y H:i')
                            : '-',

                    'opening_balance' =>
                        $shift->opening_balance,

                    'revenue' =>
                        $shift->revenue,

                    'expected_closing_balance' =>
                        $shift->expected_closing_balance,

                    'closing_balance' =>
                        $shift->closing_balance ?? 0,

                    'difference_amount' =>
                        $shift->difference_amount ?? 0,

                    'cash_payments' =>
                        $shift->cashPaymentCount,

                    'transfer_payments' =>
                        $shift->transferPaymentCount,

                    'qris_payments' =>
                        $shift->qrisPaymentCount,

                    'total_transactions' =>
                        $shift->transaction_count,

                    'status' =>
                        strtoupper($shift->status),

                ];

            });
    }

    public function headings(): array
    {
        return [

            'Cashier',

            'Opened At',

            'Closed At',

            'Opening Balance',

            'Revenue',

            'Expected Closing Balance',

            'Actual Closing Balance',

            'Difference',

            'Cash Payments',

            'Transfer Payments',

            'QRIS Payments',

            'Total Transactions',

            'Status',

        ];
    }

    public function pdf(Request $request)
    {
        $shifts = CashierShift::with('cashier')
            ->where('status', 'closed')
            ->when(
                $request->start_date,
                fn ($query) =>
                    $query->whereDate(
                        'opened_at',
                        '>=',
                        $request->start_date
                    )
            )
            ->when(
                $request->end_date,
                fn ($query) =>
                    $query->whereDate(
                        'opened_at',
                        '<=',
                        $request->end_date
                    )
            )
            ->latest()
            ->get();

        return Pdf::loadView(
            'admin.reports.cashier-shifts.pdf',
            [
                'shifts' => $shifts,
                'totalRevenue' => $shifts->sum('revenue'),
                'totalShifts' => $shifts->count(),
            ]
        )->download('cashier-shift-report.pdf');
    }

    public function excel(Request $request)
    {
        return Excel::download(
            new CashierShiftReportExport(
                $request->start_date,
                $request->end_date
            ),
            'cashier-shift-report.xlsx'
        );
    }
}