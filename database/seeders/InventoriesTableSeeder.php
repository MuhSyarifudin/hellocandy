<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class InventoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('inventories')->insert([
            [
                'product_id' => 1, // ID produk
                'quantity_change' => 10, // Penambahan stok
                'reason' => 'Stok baru',
                'date' => now(),
                'user_id' => 1, // ID pengguna yang melakukan perubahan
            ],
            [
                'product_id' => 2,
                'quantity_change' => -5, // Pengurangan stok
                'reason' => 'Penjualan',
                'date' => now(),
                'user_id' => 1,
            ],
            [
                'product_id' => 3,
                'quantity_change' => 15,
                'reason' => 'Stok baru',
                'date' => now(),
                'user_id' => 2,
            ],
            [
                'product_id' => 4,
                'quantity_change' => -3,
                'reason' => 'Penjualan',
                'date' => now(),
                'user_id' => 2,
            ],
            [
                'product_id' => 5,
                'quantity_change' => 20,
                'reason' => 'Restock',
                'date' => now(),
                'user_id' => 1,
            ],
        ]);
    }
}