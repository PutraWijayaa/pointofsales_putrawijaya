<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class orderDetails extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'order_price',
        'qty',
        'order_subtotal'
    ];

    public function order()
    {
        return $this->belongsTo(Orders::class, 'order_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }
}
