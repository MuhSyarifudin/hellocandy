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
        Schema::create('sales_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained('sales'); // ID transaksi penjualan (foreign key)
            $table->foreignId('product_id')->constrained('products'); // ID produk yang dibeli (foreign key)
            $table->integer('quantity'); // Jumlah produk yang dibeli
            $table->decimal('subtotal', 10, 2); // Total harga untuk produk ini (quantity * price)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_details');
    }
};
