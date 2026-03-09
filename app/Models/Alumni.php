<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Alumni extends Authenticatable
{
    use Notifiable;
    protected $table = 'alumni';

    protected $fillable = [
        'first_name',       // added
        'middle_initial',   // added
        'last_name', 
        'suffix',    
        'name',
        'email',
        'password',
        'gradyear',
        'course',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
