<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'code',
    'name',
    'description',
    'is_active'
])]
class Icd10Code extends Model
{
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('code', 'like', "%{$term}%")
            ->orWhere('name', 'like', "%{$term}%");
        });
    }

    public function medicalRecords()
    {
        return $this->belongsToMany(MedicalRecord::class, 'medical_record_icd10_codes')->withPivot('diagnosis_type');
    }
}
