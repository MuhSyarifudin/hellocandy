<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestOrder extends Model
{
    use HasFactory;

    protected $fillable = ['order_number', 'status', 'sale_id'];

    /**
     * Relasi dengan tabel kategori
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi dengan tabel guest_orders melalui pivot
     */
    // Definisi relasi many-to-many dengan Product
    public function products()
    {
        return $this->belongsToMany(Product::class, 'guest_order_product')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }

    // Model GuestOrder
    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    // Relasi ke tabel partner melalui GuestOrderPartner
    public function partners()
    {
        return $this->hasMany(GuestOrderPartner::class, 'guest_order_id');
    }
    public function guestOrderPartners()
    {
        return $this->hasMany(GuestOrderPartner::class, 'guest_order_id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_methods_id');
    }


    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}