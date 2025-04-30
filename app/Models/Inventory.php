<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'quantity_change',
        'reason',
        'type',
        'date',
        'user_id'
    ];

    // Relasi banyak ke satu (Inventaris terkait dengan satu produk)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi banyak ke satu (Inventaris dikelola oleh satu pengguna)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}