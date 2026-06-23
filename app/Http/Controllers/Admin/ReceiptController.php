<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    public function show(Invoice $invoice)
    {
        if (! $invoice->payment) {
            abort(404);
        }

        $invoice->load([
            'registration.patient',
            'items',
            'payment',
        ]);

        return view(
            'admin.receipts.show',
            compact('invoice')
        );
    }

    public function pdf(Invoice $invoice)
    {
        if (! $invoice->payment) {
            abort(404);
        }

        $invoice->load([
            'registration.patient',
            'items',
            'payment',
        ]);

        $pdf = Pdf::loadView(
            'admin.receipts.pdf',
            compact('invoice')
        );

        return $pdf->download(
            $invoice->payment->payment_number . '.pdf'
        );
    }
}
