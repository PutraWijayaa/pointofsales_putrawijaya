<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use League\CommonMark\Reference\Reference;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->string('product_name');

            // nullable bisa diisi bisa tidak
            $table->string('product_photo')->nullable();
            $table->decimal('product_price', 10, 2);
            $table->text('product_description')->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->timestamps();

            // $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
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
