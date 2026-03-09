<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    
    protected $table = 'messages';

   protected $fillable = [
        'client_type',
        'client_id',
        'message',
        'sender',
        'is_read',
        'solved',
        'unread_for_admin',
    ];
}

