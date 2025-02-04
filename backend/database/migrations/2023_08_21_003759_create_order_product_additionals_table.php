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
        Schema::create('order_product_additionals', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->double('additional_value');
            $table->unsignedBigInteger('product_additional_id');
            $table->foreign('product_additional_id')->references('id')->on('product_additionals');
            $table->unsignedBigInteger('order_product_id');
            $table->foreign('order_product_id')->references('id')->on('order_products');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_product_additionals');
    }
};
