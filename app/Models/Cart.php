<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    
    protected $appends = [
        'total_price'
    ];

    protected $fillable = [
        'product_id',
        'user_id',
        'guest_id',
        'quantity',
        'price',
        'tax',
        'shipping_type',
        'variation',
    ];

    public function getTotalPriceAttribute()
    {
        return $this->quantity * $this->price;
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function scopemyCarts(Builder $query)
    {
        $query->when(! auth()->check(), function ($query) {
            $query->where('guest_id', guestID());
        })->when(auth()->check(), function ($query) {
            $query->where('user_id', auth()->id());
        });
    }
}
