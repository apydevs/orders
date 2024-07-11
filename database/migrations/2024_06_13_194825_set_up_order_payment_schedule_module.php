<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up()
    {
        Schema::create('payment_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id'); // Reference to the orders table
            $table->integer('sequence_id');
            $table->decimal('payable_amount', 10, 2);
            $table->string('status')->default('pending'); // e.g., pending, completed, failed
            $table->dateTime('payment_schedule_date'); // The date payment is scheduled to be taken
            $table->dateTime('payment_made_date')->nullable(); // The date payment is scheduled to be taken
            $table->boolean('payment_processed')->default(false); // Status to indicate if the payment was processed
            $table->boolean('retry_flag')->default(false); // The date payment is scheduled to be taken
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_items');
    }
};
