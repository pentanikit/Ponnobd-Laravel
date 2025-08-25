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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->string('guest_id')->nullable();
            $table->foreignId('product_id');
            $table->json('variation')->nullable();
            $table->text('sku')->nullable();
            $table->double('price');
            $table->double('tax')->nullable();
            $table->double('shipping_cost')->nullable();
            $table->string('shipping_type')->nullable();
            $table->double('discount')->nullable();
            $table->string('coupon_code')->nullable();
            $table->tinyInteger('coupon_applied')->default(0);
            $table->string('product_referral_code')->nullable();
            $table->integer('quantity')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
