<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'method_name',
    ];

    /**
     * Relationship with the Sale model.
     */
    public function sale()
    {
        return $this->hasMany(Sale::class, 'payment_method_id');
    }
}