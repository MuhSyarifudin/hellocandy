<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Relasi ke model Expense
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}