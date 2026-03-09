<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews'; // This line ensures it's looking at the right table
    // Make sure to include all the new fields in the fillable property
    protected $fillable = [
        'client_type',  
        'contact_number', 
        'name', 
        'email',
        'message', 
        'status'
    ];
}
