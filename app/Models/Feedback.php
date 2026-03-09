<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    // Define the table if it's not the default 'feedbacks'
    protected $table = 'feedbacks';

    // Define the fillable fields that you want to allow mass assignment for
    protected $fillable = [
        'client_type',
        'date',
        'campus_transacted',
        'sex_type',
        'age',
        'contact_no',
        'service_availed',
        'CC1',
        'CC2',
        'CC3',
        'sqd_answers',
        'comments',
        'email_address',
        // Add any other fields here...
    ];
}
