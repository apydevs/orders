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




        Schema::create('gateway_references', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->integer('last_four')->nullable();
            $table->string('method')->nullable();
            $table->string('card_type')->nullable();
            $table->string('card_identifier')->nullable();
            $table->integer('expiry_date')->nullable();
            $table->boolean('reusable')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gateway_references');
    }
};
