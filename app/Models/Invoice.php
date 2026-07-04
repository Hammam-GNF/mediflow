<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'invoice_number',
    'registration_id',
    'total_amount',
    'status',
    'invoice_date',
    'notes',
    'subtotal_amount',
    'discount_amount',
    'tax_amount',
])]
class Invoice extends Model
{
    use SoftDeletes;

    protected function casts(): array
    {
        return [
            'invoice_date' => 'datetime',
            'subtotal_amount' => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'tax_amount' => 'decimal:2',
        ];
    }

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function isEditable(): bool
    {
        return ! $this->payment;
    }
}
