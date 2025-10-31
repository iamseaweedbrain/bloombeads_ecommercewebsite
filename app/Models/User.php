<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // your custom table name
    protected $table = 'useraccount';

    // if primary key is user_id (not id)
    protected $primaryKey = 'user_id';
    public $incrementing = true; // set false if primary key is non-integer
    protected $keyType = 'int';   // set 'string' if non-int

    // timestamps? set to true if created_at/updated_at exist
    public $timestamps = true;

    protected $fillable = [
        'fullName',  // use exact column names from your table
        'email',
        'phone',
        'birthday',
        'password',
        'status',
    ];

    
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
