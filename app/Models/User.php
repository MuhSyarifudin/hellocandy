<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'password',
        'role',
        'nama',
        'email'
    ];

    // Relasi satu ke banyak (User memiliki banyak penjualan)
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    // Relasi satu ke banyak (User mencatat banyak pengeluaran)
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    // Relasi satu ke banyak (User melakukan banyak perubahan inventaris)
    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    // Relasi satu ke banyak (User membuat banyak laporan)
    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}
