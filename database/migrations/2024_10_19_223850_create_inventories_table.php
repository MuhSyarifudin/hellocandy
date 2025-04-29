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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products'); // ID produk (foreign key)
            $table->integer('quantity_change'); // Jumlah perubahan stok
            $table->string('reason'); // Alasan perubahan
            $table->timestamp('date'); // Tanggal perubahan stok
            $table->foreignId('user_id')->constrained('users'); // ID pengguna yang mengelola perubahan stok (foreign key)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
