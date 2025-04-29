<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('weekly_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('reports')->onDelete('cascade'); // Foreign key referencing reports table
            $table->unsignedTinyInteger('week_number')->comment('Week number from 1 to 4'); // Week number (1-4)
            $table->decimal('total_sales', 10, 2)->default(0); // Total sales for the week
            $table->decimal('total_expenses', 10, 2)->default(0); // Total expenses for the week
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weekly_reports');
    }
};