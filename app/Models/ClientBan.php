<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientBan extends Model
{
    protected $fillable = [
        'client_type',
        'client_id',
        'email',
        'strikes',
        'banned_until',
        'is_permanent',
        'last_reason',
        'last_message',
    ];

    protected $casts = [
        'banned_until' => 'datetime',
        'is_permanent' => 'boolean',
    ];
}