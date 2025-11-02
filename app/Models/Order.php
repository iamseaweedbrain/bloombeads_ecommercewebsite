<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User; // <-- This import was missing
use App\Models\OrderItem; // <-- This is also needed

class Order extends Model
{
    use HasFactory;

    /**
     * Allow mass-assignment on all fields
     */
    protected $guarded = [];

    /**
     * Get all of the items for this order.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the user who placed the order.
     */
    public function user()
    {
        // This links to your 'useraccount' table via the user_id
        return $this->belongsTo(User::class);
    }
}
