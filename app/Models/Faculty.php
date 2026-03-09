<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Faculty extends Authenticatable
{
    use Notifiable;
    protected $table = 'faculty';

    protected $fillable = [
        'first_name',       // added
        'middle_initial',   // added
        'last_name', 
        'suffix', 
        'email',
        'password',
        'facultyId',
        'department',
    ];

    // Optional: If you're using 'facultyId' instead of 'email' for login
    public function getAuthIdentifierName()
    {
        return 'facultyId';
    }
}
