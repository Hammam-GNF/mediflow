<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'prescription_id',
    'medication_id',
    'dosage',
    'frequency',
    'duration',
    'quantity',
    'notes',
])]
class PrescriptionItem extends Model
{
    public function prescription()
    {
        return $this->belongsTo(
            Prescription::class
        );
    }

    public function medication()
    {
        return $this->belongsTo(
            Medication::class
        );
    }
}
