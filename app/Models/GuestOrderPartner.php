<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestOrderPartner extends Model
{
    use HasFactory;
    protected $table = 'guest_order_partner';

    protected $fillable = [
        'guest_order_id',
        'partner_id',
        'payment_methods_id', // Menambahkan kolom baru di sini
    ];

    // Relasi ke model GuestOrder
    public function order()
    {
        return $this->belongsTo(GuestOrder::class, 'guest_order_id');
    }

    // Relasi ke model Partner
    public function partner()
    {
        return $this->belongsTo(Partner::class, 'partner_id');
    }

    // Relasi ke model PaymentMethod
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_methods_id');
    }


}