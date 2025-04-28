<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('stock_histories', function (Blueprint $table) {
        $table->id();
        $table->foreignId('product_id')->constrained('products'); // Relasi dengan tabel products
        $table->integer('stock_change'); // Jumlah stok yang berubah (positif atau negatif)
        $table->string('transaction_type'); // Misal: 'purchase', 'sale', 'return', dll
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_histories');
    }
};
