<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'registration_id',

    'chief_complaint',

    'height',
    'weight',

    'blood_pressure',
    'heart_rate',
    'body_temperature',
    'respiratory_rate',

    'diagnosis',
    'examination_notes',

    'examined_at',

    'satusehat_condition_id',
    'satusehat_observation_id',
    'satusehat_procedure_id',
    'satusehat_composition_id',
    'satusehat_bundle_synced_at',
])]

class MedicalRecord extends Model
{
    use SoftDeletes;

    protected function casts(): array
    {
        return [
            'examined_at' => 'datetime',
            'satusehat_bundle_synced_at' => 'datetime',
        ];
    }

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    public function icd10Codes()
    {
        return $this->belongsToMany(Icd10Code::class, 'medical_record_icd10_codes')->withPivot('diagnosis_type')->withTimestamps();
    }

    public function prescription()
    {
        return $this->hasOne(Prescription::class);
    }
}