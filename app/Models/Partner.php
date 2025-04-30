<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone', 'type'];

    // Model Partner
    public function guestOrders()
    {
        return $this->hasMany(GuestOrder::class);
    }

    
}