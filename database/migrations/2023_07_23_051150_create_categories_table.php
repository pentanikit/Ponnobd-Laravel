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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->integer('parent_id')->default(0);
            $table->integer('level')->default(0);
            $table->integer('order_level')->default(0);
            $table->string('slug');
            $table->double('comission_rate')->default(0.00);
            $table->string('icon')->nullable();
            $table->enum('featured', [0, 1])->nullable()->default(0)->comment('0=inactive;1=active');
            $table->enum('top', [0, 1])->nullable()->default(0)->comment('0=inactive;1=active');
            $table->enum('digital', [0, 1])->nullable()->default(0)->comment('0=inactive;1=active');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
