<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    protected $fillable = [
        'access_token',
        'issued_at',
        'expiration',
        'is_valid',
    ];

    protected $casts = [
        'is_valid' => 'boolean',
    ];
}