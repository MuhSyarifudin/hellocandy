<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class Report_detailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('report_details')->insert([
            [
                'report_id' => 6, // Mengacu pada ID laporan 1
                'total_sales' => 1000000.00,
                'total_expenses' => 300000.00,
                'period_start' => now()->subDays(30),
                'period_end' => now(),
            ],
            [
                'report_id' => 7, // Mengacu pada ID laporan 2
                'total_sales' => 800000.00,
                'total_expenses' => 250000.00,
                'period_start' => now()->subDays(60),
                'period_end' => now()->subDays(30),
            ],
            [
                'report_id' => 8, // Mengacu pada ID laporan 3
                'total_sales' => 900000.00,
                'total_expenses' => 400000.00,
                'period_start' => now()->subDays(90),
                'period_end' => now()->subDays(60),
            ],
            [
                'report_id' => 9, // Mengacu pada ID laporan 4
                'total_sales' => 1100000.00,
                'total_expenses' => 350000.00,
                'period_start' => now()->subDays(120),
                'period_end' => now()->subDays(90),
            ],
            [
                'report_id' => 10, // Mengacu pada ID laporan 5
                'total_sales' => 950000.00,
                'total_expenses' => 300000.00,
                'period_start' => now()->subDays(150),
                'period_end' => now()->subDays(120),
            ],
        ]);
    }
}