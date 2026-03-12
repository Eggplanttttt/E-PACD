<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Other extends Authenticatable
{
    use Notifiable;

    protected $table = 'others';

    protected $fillable = [
        'email',
        'first_name',
        'middle_initial',
        'last_name',
        'suffix',
        'address',
        'contact_number',
        'client_type',
        'fb_id',
        'fb_avatar',
        'fb_verified',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
