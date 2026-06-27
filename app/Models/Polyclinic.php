<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'name',
    'description',
    'satusehat_location_id',
    'is_active'
])]

class Polyclinic extends Model
{
    use SoftDeletes;

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
}
