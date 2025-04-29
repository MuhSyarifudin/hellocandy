<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class Sales_detailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sales_details')->insert([
            [
                'sale_id' => 1, // ID transaksi penjualan
                'product_id' => 1, // ID produk
                'quantity' => 2,
                'subtotal' => 100000,
            ],
            [
                'sale_id' => 1,
                'product_id' => 3,
                'quantity' => 1,
                'subtotal' => 60000,
            ],
            [
                'sale_id' => 2,
                'product_id' => 2,
                'quantity' => 3,
                'subtotal' => 135000,
            ],
            [
                'sale_id' => 3,
                'product_id' => 4,
                'quantity' => 5,
                'subtotal' => 150000,
            ],
            [
                'sale_id' => 4,
                'product_id' => 5,
                'quantity' => 10,
                'subtotal' => 250000,
            ],
        ]);
    }
}