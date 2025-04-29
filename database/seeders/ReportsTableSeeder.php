<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ReportsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('reports')->insert([
            [
                'report_name' => 'Laporan Bulan Januari',
                'report_date' => now(),
                'user_id' => 1,
            ],
            [
                'report_name' => 'Laporan Bulan Februari',
                'report_date' => now()->subDays(30),
                'user_id' => 2,
            ],
            [
                'report_name' => 'Laporan Bulan Maret',
                'report_date' => now()->subDays(60),
                'user_id' => 1,
            ],
            [
                'report_name' => 'Laporan Bulan April',
                'report_date' => now()->subDays(90),
                'user_id' => 1,
            ],
            [
                'report_name' => 'Laporan Bulan Mei',
                'report_date' => now()->subDays(120),
                'user_id' => 2,
            ],
        ]);
    }
}