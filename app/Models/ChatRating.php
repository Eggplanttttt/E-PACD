<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRating extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_guard',
        'client_type',
        'client_id',
        'client_name',
        'client_email',
        'stars',
    ];
}
