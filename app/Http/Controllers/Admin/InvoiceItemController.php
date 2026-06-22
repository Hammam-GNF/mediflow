<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreInvoiceItemRequest;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Support\Facades\Auth;

class InvoiceItemController extends Controller
{
    public function store(StoreInvoiceItemRequest $request, Invoice $invoice)
    {
        if ($invoice->status !== 'unpaid') {
            abort(403);
        }

        $subtotal =
            $request->quantity *
            $request->unit_price;

        $invoice->items()->create([
            'item_name' => $request->item_name,
            'quantity' => $request->quantity,
            'unit_price' => $request->unit_price,
            'subtotal' => $subtotal,
        ]);

        $invoice->update([
            'total_amount' =>
                $invoice->items()->sum('subtotal')
        ]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($invoice)
            ->event('item_added')
            ->log('Invoice item added');

        return back()->with(
            'success',
            'Invoice item added successfully.'
        );
    }

    public function destroy(InvoiceItem $invoiceItem)
    {
        $invoice = $invoiceItem->invoice;

        if ($invoice->status !== 'unpaid') {
            abort(403);
        }

        $invoiceItem->delete();

        $invoice->refresh();

        $invoice->update([
            'total_amount' =>
                $invoice->items()->sum('subtotal')
        ]);

        activity()
            ->causedBy(Auth::user())
            ->performedOn($invoice)
            ->event('item_deleted')
            ->log('Invoice item deleted');

        return back()->with(
            'success',
            'Invoice item deleted successfully.'
        );
    }
}