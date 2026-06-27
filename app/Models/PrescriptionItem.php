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
    'satusehat_medication_id',
    'satusehat_medication_request_id',
    'satusehat_synced_at',
])]
class PrescriptionItem extends Model
{
    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }

    public function medication()
    {
        return $this->belongsTo(Medication::class);
    }

    protected function casts(): array
    {
        return [
            'satusehat_synced_at' => 'datetime',
        ];
    }
}
