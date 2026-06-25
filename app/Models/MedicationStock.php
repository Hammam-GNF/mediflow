<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'medication_id',
    'current_stock',
])]
class MedicationStock extends Model
{
    public function medication()
    {
        return $this->belongsTo(Medication::class);
    }
}
