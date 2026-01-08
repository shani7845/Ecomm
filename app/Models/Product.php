<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
protected $fillable = [
    'category_id',
    'name',
    'slug',
    'image',
    'status',
    'price',
    'description',
    'stock'
];

// Category this product belongs to
    public function category(){
        return $this->belongsTo(Category::class);
    }
}