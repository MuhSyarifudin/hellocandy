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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('report_name'); // Nama laporan (contoh: "Laporan Penjualan Bulanan")
            $table->timestamp('report_date'); // Tanggal laporan dibuat
            $table->foreignId('user_id')->constrained('users'); // ID pengguna yang membuat laporan (foreign key)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};