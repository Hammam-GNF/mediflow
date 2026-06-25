<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'code',
    'name',
    'unit',
    'price',
    'is_active',
])]
class Medication extends Model
{
    public function prescriptionItems()
    {
        return $this->hasMany(PrescriptionItem::class);
    }

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function stock()
    {
        return $this->hasOne(MedicationStock::class);
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }
}
