<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Student extends Authenticatable
{
    use Notifiable, HasFactory;

    // Define the attributes that can be mass-assigned
    protected $fillable = [
        'first_name',    
        'middle_initial',   
        'last_name', 
        'suffix',      
        'email',
        'idnumber',
        'course_year',
        'password',
    ];

    // Override the method to use 'idnumber' for authentication
    public function getAuthIdentifierName()
    {
        return 'idnumber'; // Use 'idnumber' instead of 'email'
    }
}
