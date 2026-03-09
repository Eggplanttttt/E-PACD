<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentMessage extends Model
{
    use HasFactory;

    // Specify the table name if it's not the plural of the model name
    protected $table = 'messages';

    // Allow mass assignment for these fields
    protected $fillable = ['client_id', 'client_type', 'message', 'sender'];
}
