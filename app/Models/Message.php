<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    
    protected $table = 'messages';

    protected $appends = [
        'attachment_url',
    ];

   protected $fillable = [
        'client_type',
        'client_id',
        'message',
        'attachment_path',
        'attachment_name',
        'attachment_mime',
        'attachment_type',
        'sender',
        'is_read',
        'solved',
        'unread_for_admin',
    ];

    public function getAttachmentUrlAttribute(): ?string
    {
        return $this->attachment_path ? asset($this->attachment_path) : null;
    }
}
