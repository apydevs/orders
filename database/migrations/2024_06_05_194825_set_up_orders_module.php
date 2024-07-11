<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->string('customer_account_no');
            $table->string('billing_address'); // Example billing address saved
            $table->string('delivery_address'); // Example billing address saved
            $table->integer('vat_rate')->nullable();
            $table->decimal('vat', 10,2)->nullable();
            $table->decimal('total_price', 10, 2);
            $table->string('status')->default('pending'); // Example statuses: pending, processing, completed, cancelled
            $table->string('payment_method')->default('card'); // Example methods: credit_card, paypal, bank_transfer
            $table->string('payment_schedule')->default('weekly'); // Example schedules: one_time, weekly, bi-weekly, monthly
            $table->unsignedTinyInteger('duration')->nullable(); // Duration in weeks or months depending on the payment schedule
            $table->text('notes')->nullable(); // Optional field for any notes related to the order
            $table->uuid('translation_id')->nullable();
            $table->uuid('card_identifier')->nullable();
            $table->string('gateway_status_code')->nullable();
            $table->string('gateway_status')->nullable();
            $table->string('transaction_type')->nullable();
            $table->integer('gateway_total_amount')->nullable();
            $table->timestamps();
            $table->softDeletes(); // Enable soft deletes
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('restrict');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
