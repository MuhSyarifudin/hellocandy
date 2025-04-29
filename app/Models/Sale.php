<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'total_amount',
        'payment_method_id',
        'user_id'
    ];

    // Relasi banyak ke satu (Penjualan dilakukan oleh satu kasir)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi satu ke banyak (Penjualan memiliki banyak detail penjualan)
    public function salesDetails()
    {
        return $this->hasMany(SalesDetail::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }
}