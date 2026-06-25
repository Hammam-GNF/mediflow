<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SatusehatToken extends Model
{
    protected $fillable = [
        'access_token',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
        ];
    }
}
