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
        Schema::table('sales', function (Blueprint $table) {
            // Add the payment_method_id column and set up the foreign key relationship
            $table->foreignId('payment_method_id')->nullable()->constrained('payment_methods')->after('total_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
             // Remove the foreign key and the column
             $table->dropForeign(['payment_method_id']);
             $table->dropColumn('payment_method_id');
        });
    }
};