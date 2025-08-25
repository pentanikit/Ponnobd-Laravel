<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'num_of_sale'];

    public function scopePublish(Builder $query)
    {
        $query->where('status', 'publish');
    }

    public function scopeFeatured(Builder $query)
    {
        $query->where('featured', 1);
    }

    public function scopeOrderByPrice(Builder $query, $order = 'asc')
    {
        if (! $this->variant_product && ! is_null($this->discount) && $this->discount > 0) {
            $query->orderBy('discount');

            return;
        } elseif ($this->variant_product) {
            $query->whereHas('stocks', function ($query) use ($order) {
                $query->orderBy('price', $order);
            });

            return;
        }

        $query->orderBy('unit_price', $order);

    }

    public function scopeTopSell(Builder $query)
    {
        $query->orderByDesc('num_of_sale');
    }

    public function categories()
    {
        return $this->hasMany(ProductCategories::class, 'product_id', 'id');
    }

    public function stocks()
    {
        return $this->hasMany(ProductStock::class, 'product_id', 'id');
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class, 'product_id', 'id');
    }

    public function brand()
    {
        return $this->hasOne(Brand::class, 'id', 'brand_id');
    }

    public function regularPrice($formatted = true)
    {
        $price = $this->unit_price;
        $tax = 0;

        if ($this->tax_type == 'percent') {
            $tax += ($price * $this->tax) / 100;
        } elseif ($this->tax_type == 'amount') {
            $tax += $this->tax;
        }

        $price += $tax;

        return $formatted ? formatPrice($price) : $price;
    }

    public function discountPrice($formatted = true)
    {
        $regular_price = $this->unit_price;
        $tax = 0;

        $sale_price = $this->discount != null && $this->discount > 0 ? $this->discount : $regular_price;

        if ($this->tax_type == 'percent') {
            $tax += ($sale_price * $this->tax) / 100;
        } elseif ($this->tax_type == 'amount') {
            $tax += $this->tax;
        }

        $sale_price += $tax;

        return $formatted ? formatPrice($sale_price) : $sale_price;
    }

    public function discountInPercentage()
    {
        try {
            $regular_price = $this->regularPrice(false);
            $discount_price = $this->discountPrice(false);
            if($regular_price > 0 && $discount_price > 0){
                $dp = (($regular_price - $discount_price) / $regular_price) * 100;
            }else{
                $dp = 0;
            }

            return round($dp);

        } catch (Exception $e) {
            return 0;
        }
    }

    protected $casts = [
        'category_ids' => 'array',
        'attributes' => 'json',
        'choice_options' => 'json',
        'photos' => 'array',
    ];
}
