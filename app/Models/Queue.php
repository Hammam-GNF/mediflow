<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'registration_id',
    'queue_number',
    'queue_date',
    'status',
])]

class Queue extends Model
{
    use SoftDeletes;

    protected function casts(): array
    {
        return [
            'queue_date' => 'datetime',
        ];
    }

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }
}