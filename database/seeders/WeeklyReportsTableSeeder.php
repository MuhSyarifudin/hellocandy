<?php

namespace Database\Seeders;

use App\Models\WeeklyReport;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WeeklyReportsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ([6, 7, 8, 9, 10, 11, 13, 15, 16] as $reportId) {
            for ($weekNumber = 1; $weekNumber <= 4; $weekNumber++) {
                WeeklyReport::create([
                    'report_id' => $reportId,
                    'week_number' => $weekNumber,
                    'total_sales' => rand(1000, 5000), // Random total sales for the week
                    'total_expenses' => rand(500, 2000), // Random total expenses for the week
                ]);
            }
        }
    }
}