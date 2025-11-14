<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Component extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $appends = ['full_image_url'];

    public function componentCategory()
    {
        return $this->belongsTo(ComponentCategory::class);
    }

    public function getFullImageUrlAttribute() 
    {
        if ($this->image_path) {
            return asset('storage/' . $this->image_path);
        }
        
        return 'https://placehold.co/64x64/f0f0f0/333?text=N/A';
    }
}