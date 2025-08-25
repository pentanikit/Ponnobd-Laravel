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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id');
            $table->foreignId('seller_id');
            $table->foreignId('product_id');
            $table->json('variation')->nullable();
            $table->string('created_via');
            $table->longText('sku')->nullable();
            $table->double('price');
            $table->double('tax')->default(0.00);
            $table->double('shipping_cost')->default(0.00);
            $table->integer('quantity');
            $table->string('shipping_type')->nullable();
            $table->text('product_referral_code')->nullable();
            $table->enum('status', ['pending', 'processing', 'on_hold', 'completed', 'cancelled', 'refunded'])->default('pending');
            $table->enum('payment_status', ['paid', 'unpaid'])->default('unpaid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
