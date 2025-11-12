<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    use HasFactory;

    // This prevents mass assignment errors
    protected $guarded = [];

    /**
     * Get the category that this component belongs to.
     */
    public function componentCategory()
    {
        return $this->belongsTo(ComponentCategory::class);
    }
}