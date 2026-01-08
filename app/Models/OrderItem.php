<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    /**
     * Timestamps columns may be missing in some environments.
     * Disable automatic timestamps to avoid SQL errors until migrations run.
     */
    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'product_id',
        'qty',
        'price',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
