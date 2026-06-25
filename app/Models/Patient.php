<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'medical_record_number',
    'name',
    'nik',
    'satusehat_patient_id',
    'gender',
    'birth_date',
    'phone',
    'address',
    'is_active',
])]

class Patient extends Model
{
    use SoftDeletes;

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function medicalRecords()
    {
        return $this->hasManyThrough(
            MedicalRecord::class,
            Registration::class
        );
    }
}
