<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;


class AdminAccount extends Authenticatable
{
    use HasFactory, Notifiable; 

    protected $table = 'admin_account'; // Database table name

    protected $primaryKey = 'id'; // Primary key column

    public $timestamps = true; // Set to true if you have created_at & updated_at

    protected $fillable = [
        'firstname',
        'lastname',
        'middlename',
        'suffix',
        'email',
        'password',
        'image',
        'role'
    ];

    protected $dates = ['last_active_at'];

    // // Mutator to hash passwords before saving
    // public function setPasswordAttribute($value)
    // {
    //     $this->attributes['password'] = bcrypt($value);
    // }

    // Relationship: One admin manages many complaints
    public function complaints()
    {
        return $this->hasMany(Complaint::class, 'user_id');
    }
}

class Complaint extends Model
{
    use HasFactory;

    protected $table = 'complaints';

    protected $fillable = [
        'user_id',
        'subject',
        'description',
        'status',
    ];

    // Relationship: Each complaint belongs to one admin
    public function admin()
    {
        return $this->belongsTo(AdminAccount::class, 'user_id');
    }
}
