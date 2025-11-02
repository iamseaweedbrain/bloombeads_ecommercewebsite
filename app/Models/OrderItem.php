<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product; // This import is correct

class OrderItem extends Model
{
    use HasFactory;
    
    /**
     * Allow mass-assignment on all fields
     */
    protected $guarded = [];

    /**
     * Get the product that this item refers to.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
