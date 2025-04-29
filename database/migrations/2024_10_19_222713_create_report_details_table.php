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
        Schema::create('report_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('reports'); // ID laporan (foreign key)
            $table->decimal('total_sales', 10, 2); // Total penjualan untuk laporan ini
            $table->decimal('total_expenses', 10, 2); // Total pengeluaran untuk laporan ini
            $table->timestamp('period_start')->nullable(); // Tanggal mulai periode laporan
            $table->timestamp('period_end')->nullable(); // Tanggal akhir periode laporan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_details');
    }
};