<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'invoice_id',
    'item_name',
    'quantity',
    'unit_price',
    'subtotal',
])]
class InvoiceItem extends Model
{
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}