<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'username' => 'owner',
            'password' => Hash::make('owner123'), // Gunakan bcrypt untuk hash password
            'role' => 'owner',
            'nama' => 'Owner Utama',
            'email' => 'owner@example.com',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Buat pengguna 'kasir' dengan data pasti
        DB::table('users')->insert([
            'username' => 'kasir_utama',
            'password' => Hash::make('kasir123'),
            'role' => 'kasir',
            'nama' => 'Kasir Utama',
            'email' => 'kasir@example.com',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}