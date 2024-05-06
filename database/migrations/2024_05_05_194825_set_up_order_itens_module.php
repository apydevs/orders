<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id');
            $table->string('product_title');
            $table->string('product_type')->nullable();
            $table->string('product_description')->nullable();
            $table->string('product_manufacture')->nullable();
            $table->string('product_model')->nullable();
            $table->integer('quantity');
            $table->integer('vat_rate'); // Price per item
            $table->decimal('vat', 10, 2); // Price per item
            $table->decimal('price', 10, 2); // Price per item
            $table->timestamps();
            $table->softDeletes(); // Enable soft deletes

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products'); // Assuming 'products' table exists
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_items');
    }
};
