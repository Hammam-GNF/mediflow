<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'registration_number',
    'patient_id',
    'doctor_id',
    'polyclinic_id',
    'registration_date',
    'complaint',
    'status',
])]

class Registration extends Model
{
    use SoftDeletes;

    protected function casts(): array
    {
        return [
            'registration_date' => 'datetime',
        ];
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function polyclinic()
    {
        return $this->belongsTo(Polyclinic::class);
    }
}
