<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ExpensesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('expenses')->insert([
            [
                'expense_name' => 'Pembelian Bunga',
                'amount' => 50000,
                'date' => now(),
                'user_id' => 1, // ID pengguna
            ],
            [
                'expense_name' => 'Biaya Transportasi',
                'amount' => 30000,
                'date' => now()->subDays(1),
                'user_id' => 2,
            ],
            [
                'expense_name' => 'Pembayaran Sewa Toko',
                'amount' => 100000,
                'date' => now()->subDays(2),
                'user_id' => 1,
            ],
            [
                'expense_name' => 'Pembelian Peralatan',
                'amount' => 75000,
                'date' => now()->subDays(3),
                'user_id' => 1,
            ],
            [
                'expense_name' => 'Pemasaran',
                'amount' => 45000,
                'date' => now()->subDays(4),
                'user_id' => 2,
            ],
        ]);
    }
}