<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutSection extends Model
{
    //
    protected $fillable = [
        'small_title',
        'title',
        'description',
        'image',
        'is_active'
    ];
}
