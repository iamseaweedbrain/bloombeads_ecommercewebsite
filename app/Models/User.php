<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The table associated with the model.
     */
    protected $table = 'useraccount';

    /**
     * The primary key associated with the table.
     */
    protected $primaryKey = 'user_id';

    /**
     * Indicates if the model's ID is auto-incrementing.
     */
    public $incrementing = true; // Set false if primary key is non-integer

    /**
     * The data type of the auto-incrementing ID.
     */
    protected $keyType = 'int'; // set 'string' if non-int

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = true; // set to true if created_at/updated_at exist

    /**
     * The attributes that are mass assignable.
     *
     * We are using the list from the 'current' (main) branch as it
     * includes 'phone' and 'birthday' which seem like the latest additions.
     */
    protected $fillable = [
        'fullName',
        'email',
        'phone',
        'birthday',
        'password',
        'status',
        // 'user_id' is not needed in fillable if it's an auto-incrementing primary key
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * This combines the casts from both versions, using the modern
     * function syntax from your stashed changes.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the cart associated with the user.
     *
     * This function was added from your stashed changes.
     */
    public function cart()
    {
        return $this->hasOne(Cart::class, 'user_id');
    }
}
