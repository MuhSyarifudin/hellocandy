<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'product_name' => 'Mawar Merah',
                'category_id' => 1, // ID kategori Bunga Segar
                'price' => 50000,
                'stock' => 100,
                'description' => 'Bunga mawar merah segar',
            ],
            [
                'product_name' => 'Mawar Putih',
                'category_id' => 1,
                'price' => 45000,
                'stock' => 80,
                'description' => 'Bunga mawar putih segar',
            ],
            [
                'product_name' => 'Bunga Matahari',
                'category_id' => 1,
                'price' => 60000,
                'stock' => 60,
                'description' => 'Bunga matahari cerah',
            ],
            [
                'product_name' => 'Tanaman Lidah Mertua',
                'category_id' => 3,
                'price' => 30000,
                'stock' => 50,
                'description' => 'Tanaman hias lidah mertua',
            ],
            [
                'product_name' => 'Pupuk Organik',
                'category_id' => 5,
                'price' => 25000,
                'stock' => 120,
                'description' => 'Pupuk organik untuk semua jenis tanaman',
            ],
        ]);
    }
}