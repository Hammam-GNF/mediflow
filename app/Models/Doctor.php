<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'user_id',
    'polyclinic_id',
    'doctor_code',
    'nik',
    'sip_number',
    'satusehat_practitioner_id',
    'satusehat_synced_at',
    'phone',
    'address',
    'is_active',
])]

class Doctor extends Model
{
    use SoftDeletes, HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function polyclinic()
    {
        return $this->belongsTo(Polyclinic::class);
    }

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'satusehat_synced_at' => 'datetime',
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
