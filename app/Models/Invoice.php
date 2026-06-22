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
])]
class Invoice extends Model
{
    use SoftDeletes;

    protected function casts(): array
    {
        return [
            'invoice_date' => 'datetime',
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
}
