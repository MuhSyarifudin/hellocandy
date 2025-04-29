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
        'stock',
        'description'
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
}