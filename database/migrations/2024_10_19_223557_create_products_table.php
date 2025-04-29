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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name'); // Nama produk
            $table->foreignId('category_id')->constrained('categories'); // Kategori produk (foreign key)
            $table->decimal('price', 10, 2); // Harga produk
            $table->integer('stock'); // Jumlah stok
            $table->text('description')->nullable(); // Deskripsi produk (opsional)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};