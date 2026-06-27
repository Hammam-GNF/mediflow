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
    'satusehat_encounter_id',
    'satusehat_sync_status',
    'satusehat_synced_at',
    'satusehat_error_message',
])]

class Registration extends Model
{
    use SoftDeletes;

    protected function casts(): array
    {
        return [
            'registration_date' => 'datetime',
            'satusehat_synced_at' => 'datetime',
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

    public function queue()
    {
        return $this->hasOne(Queue::class);
    }

    public function medicalRecord()
    {
        return $this->hasOne(MedicalRecord::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
