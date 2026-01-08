<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{
    protected $fillable = [
        'order_id',
        'type',
        'name',
        'email',
        'phone',
        'address',
        'city',
        'pincode',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
