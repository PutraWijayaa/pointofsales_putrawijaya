<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $fillable = [
        'category_id',
        'product_name',
        'product_price',
        'product_photo',
        'product_description',
        'qty_awal',
        'qty_keluar',
        'qty_akhir',
        'is_active',
    ];

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id', 'id');
    }

    public function reduceStock($quantity)
    {
        // Cek apakah stok cukup
        if ($this->qty_akhir >= $quantity) {
            $this->qty_keluar += $quantity;
            $this->qty_akhir -= $quantity;
            $this->save();
            return true;
        }

        return false; // Stok tidak cukup
    }
}
