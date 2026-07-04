<?php

namespace App\Observers;

use App\Models\InvoiceItem;

class InvoiceItemObserver
{
    public function created(InvoiceItem $invoiceItem): void
    {
        $this->updateInvoice($invoiceItem);
    }

    public function updated(InvoiceItem $invoiceItem): void
    {
        $this->updateInvoice($invoiceItem);
    }

    public function deleted(InvoiceItem $invoiceItem): void
    {
        $this->updateInvoice($invoiceItem);
    }

    private function updateInvoice(InvoiceItem $invoiceItem): void
    {
        $invoice = $invoiceItem->invoice;

        $subtotal = $invoice
            ->items()
            ->sum('subtotal');

        $total =
            $subtotal
            - $invoice->discount_amount
            + $invoice->tax_amount;

        $invoice->update([

            'subtotal_amount' => $subtotal,

            'total_amount' => max(
                $total,
                0
            ),

        ]);
    }
}