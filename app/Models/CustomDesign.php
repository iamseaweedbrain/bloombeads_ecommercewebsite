<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomDesign extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * @var array
     */
    protected $casts = [
        'design_data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}