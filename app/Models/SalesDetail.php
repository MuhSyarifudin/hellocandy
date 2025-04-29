<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'subtotal'
    ];

    // Relasi banyak ke satu (Detail penjualan milik satu penjualan)
    public function sale() {
        return $this->belongsTo(Sale::class);
    }

    // Relasi banyak ke satu (Detail penjualan terkait dengan satu produk)
    public function product() {
        return $this->belongsTo(Product::class);
    }
}