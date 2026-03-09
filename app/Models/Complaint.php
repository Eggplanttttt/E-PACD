<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $table = 'complaints'; // Define the table name

    // Add the new columns to the fillable property
    protected $fillable = [
        'name', 
        'email', 
        'message', 
        'status', 
        'client_type',
        'department',
        'contact_number',
        'image',
        'video'
    ];


    // If you don't want timestamps to be managed by Laravel
    // public $timestamps = false;
}
