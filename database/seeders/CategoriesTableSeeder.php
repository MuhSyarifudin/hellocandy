<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['category_name' => 'Bunga Segar'],
            ['category_name' => 'Bunga Kering'],
            ['category_name' => 'Tanaman Hias'],
            ['category_name' => 'Aksesori Bunga'],
            ['category_name' => 'Pupuk dan Nutrisi'],
        ]);
    }
}