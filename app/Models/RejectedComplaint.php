<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RejectedComplaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'client_type',
        'department',
        'contact_number',
        'message',
        'spam_reason',
        'image',
        'video',
        'status',
    ];
}

