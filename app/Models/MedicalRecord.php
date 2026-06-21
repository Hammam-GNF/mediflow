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
])]

class MedicalRecord extends Model
{
    use SoftDeletes;

    protected function casts(): array
    {
        return [
            'examined_at' => 'datetime',
        ];
    }

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
}