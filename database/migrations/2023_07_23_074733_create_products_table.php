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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('user_id');
            $table->json('category_ids');
            $table->integer('brand_id')->nullable();
            $table->json('photos')->nullable();
            $table->string('thumbnail_img')->nullable();
            $table->string('featured_img')->nullable();
            $table->string('flash_deal_img')->nullable();
            $table->mediumText('tags')->nullable();
            $table->longText('description')->nullable();
            $table->longText('short_description')->nullable();
            $table->double('unit_price')->nullable();
            // $table->double('purchase_price')->nullable();
            $table->integer('variant_product')->nullable()->default(0);
            $table->string('attributes', 2000)->nullable();
            $table->mediumText('choice_options')->nullable();
            $table->text('variations')->nullable();
            $table->integer('todays_deal')->nullable()->default(0);
            $table->integer('featured')->nullable()->default(0);
            $table->integer('current_stock')->default(0)->nullable();
            $table->string('unit')->nullable();
            $table->string('weight')->nullable();
            $table->integer('min_qty')->default(1);
            $table->double('discount')->nullable();
            $table->string('discount_type')->nullable();
            $table->double('tax')->nullable();
            $table->string('tax_type')->nullable();
            $table->double('vat')->nullable();
            $table->string('vat_type')->nullable();
            $table->string('shipping_type')->nullable()->default('flat_rate');
            $table->double('shipping_cost')->nullable()->default(0);
            $table->integer('est_shipping_days')->nullable();
            $table->double('num_of_sale')->nullable()->default(0);
            $table->mediumText('meta_title')->nullable();
            $table->longText('meta_description')->nullable();
            $table->string('meta_img')->nullable();
            $table->mediumText('slug')->nullable();
            $table->integer('refundable')->nullable()->default(0);
            $table->double('rating')->nullable()->default(0);
            $table->string('barcode')->nullable()->default(0);
            $table->integer('digital')->nullable()->default(0);
            $table->string('file_name')->nullable();
            $table->string('file_path')->nullable();
            $table->enum('status', ['publish', 'draft', 'unpublish'])->default('publish');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
