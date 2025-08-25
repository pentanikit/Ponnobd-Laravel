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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->integer('guest_id')->nullable();
            $table->string('code')->nullable();
            $table->text('note')->nullable();
            $table->json('shipping');
            $table->json('billing');
            $table->string('payment_type')->nullable();
            $table->longText('payment_details')->nullable();
            $table->double('coupon_discount')->default(0.00);
            $table->double('coupon_code')->nullable();
            $table->double('total')->nullable();
            $table->ipAddress();
            $table->text('user_agent');
            $table->integer('viewed')->default(0);
            $table->enum('status', ['pending', 'processing', 'on_hold', 'completed', 'cancelled', 'refunded'])->default('pending');
            $table->enum('payment_status', ['paid', 'unpaid'])->default('unpaid');
            $table->integer('delivery_viewed')->default(1);
            $table->integer('payment_status_viewed')->default(1);
            $table->integer('commission_calculated')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
