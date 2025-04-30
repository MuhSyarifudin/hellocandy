<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'expense_name',
        'amount',
        'date',
        'user_id',
        'payment_type_id',
        'note'
    ];


    // Cast 'date' as a Carbon instance
    protected $casts = [
        'date' => 'datetime',
    ];
    // Relasi banyak ke satu (Pengeluaran dicatat oleh satu pengguna)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class);
    }
}
