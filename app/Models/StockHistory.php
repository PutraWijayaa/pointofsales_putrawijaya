<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockHistory extends Model
{
    protected $fillable = ['product_id', 'stock_change', 'transaction_type'];

    // Relasi dengan produk
    public function product()
    {
        return $this->belongsTo(Products::class);
    }
}
