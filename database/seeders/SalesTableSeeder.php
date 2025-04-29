<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SalesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sales')->insert([
            [
                'date' => now(),
                'total_amount' => 200000,
                'payment_method' => 'Cash',
                'user_id' => 1, // ID kasir
            ],
            [
                'date' => now()->subDays(1),
                'total_amount' => 150000,
                'payment_method' => 'Card',
                'user_id' => 2,
            ],
            [
                'date' => now()->subDays(2),
                'total_amount' => 300000,
                'payment_method' => 'Card',
                'user_id' => 1,
            ],
            [
                'date' => now()->subDays(3),
                'total_amount' => 400000,
                'payment_method' => 'Cash',
                'user_id' => 1,
            ],
            [
                'date' => now()->subDays(4),
                'total_amount' => 250000,
                'payment_method' => 'Card',
                'user_id' => 2,
            ],
        ]);
    }
}