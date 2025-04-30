<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = ['method_name', 'type'];

    protected $table = 'payment_methods';

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

     // Relasi ke GuestOrderPartner
     public function guestOrderPartners()
     {
         return $this->hasMany(GuestOrderPartner::class);
     }

     public function guestOrders()
     {
         return $this->hasMany(GuestOrder::class);
     }

}