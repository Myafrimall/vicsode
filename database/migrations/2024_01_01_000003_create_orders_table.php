<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->string('status')->default('pending');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('delivery_fee', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            // Customer details
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            // Delivery details
            $table->string('delivery_address');
            $table->string('delivery_city');
            $table->string('delivery_state')->nullable();
            $table->string('delivery_zip');
            $table->string('delivery_country')->default('South Africa');
            $table->text('delivery_notes')->nullable();
            // Payment
            $table->string('payment_method')->default('card');
            $table->string('payment_status')->default('pending');
            $table->string('payment_reference')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
