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

        $invoice->update([
            'total_amount' => $invoice->items()->sum('subtotal'),
        ]);
    }
}