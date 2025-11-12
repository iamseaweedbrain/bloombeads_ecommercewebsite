<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComponentCategory extends Model
{
    use HasFactory;

    // This prevents mass assignment errors
    protected $guarded = [];

    /**
     * Get all of the components that belong to this category.
     */
    public function components()
    {
        return $this->hasMany(Component::class);
    }
}