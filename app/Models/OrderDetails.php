<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;

    public function order()
    {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }

    public function seller()
    {
        return $this->hasOne(User::class, 'id', 'seller_id');
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    protected $fillable = [
        'order_id',
        'seller_id',
        'product_id',
        'created_via',
        'price',
        'variation',
        'quantity',
        'shipping_type',
        'status',
    ];

    protected $casts = [
        'variation' => 'array',
    ];
}
