<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'user_id',
    'opened_at',
    'closed_at',
    'opening_balance',
    'closing_balance',
    'status',
    'notes',
    'difference_amount',
])]
class CashierShift extends Model
{
    protected function casts(): array
    {
        return [
            'opened_at' => 'datetime',
            'closed_at' => 'datetime',
            'opening_balance' => 'decimal:2',
            'closing_balance' => 'decimal:2',
        ];
    }

    public function cashier()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getTransactionCountAttribute()
    {
        return $this->payments()->count();
    }

    public function getRevenueAttribute()
    {
        return $this->payments()->sum('amount');
    }

    public function getExpectedClosingBalanceAttribute()
    {
        return $this->opening_balance + $this->revenue;
    }

    public function getDifferenceAmountAttribute()
    {
        if ($this->closing_balance === null) {
            return null;
        }

        return $this->closing_balance - $this->expected_closing_balance;
    }
}