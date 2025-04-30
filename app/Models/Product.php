<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'category_id',
        'price',
        'purchase_price',
        'stock',
        'unit',
        'image',
        'description',
    ];

    // Relasi satu ke banyak (Produk memiliki banyak detail penjualan)
    public function salesDetails() {
        return $this->hasMany(SalesDetail::class);
    }

    // Relasi banyak ke satu (Produk milik satu kategori)
    public function category() {
        return $this->belongsTo(Category::class);
    }

    // Relasi satu ke banyak (Produk memiliki banyak catatan inventaris)
    public function inventories() {
        return $this->hasMany(Inventory::class);
    }
    // Relasi ke tabel guest_orders melalui tabel pivot
    public function guestOrders()
    {
        return $this->belongsToMany(GuestOrder::class, 'guest_order_product')
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }
}
