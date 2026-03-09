<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplaintSolved extends Model
{
    use HasFactory;

    protected $table = 'complaint_solved';

    protected $fillable = [
        'name',
        'email',
        'client_type',
        'department',
        'contact_number',
        'message',
        'image',
        'video',

        // NEW RESOLUTION FIELDS
        'sent_to',
        'sent_date',
        'action_taken',
        'action_date',

        'status',
    ];
}