<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSection extends Model
{
    protected $table = 'hero_sections'; // 🔥 ADD THIS LINE

    protected $fillable = [
        'sub_title',
        'title',
        'hero_image',
        'is_active'
    ];
}
