<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // ✅ correct relation type
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // keep your existing
    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class, 'order_id', 'id');
    }

    // ✅ optional alias so old views using $order->items keep working
    public function items()
    {
        return $this->orderDetails();
    }

    protected $fillable = [
        'user_id','guest_id','note','code','shipping','billing',
        'payment_type','total','ip_address','user_agent','status',
        // 'email', // ← add if you decide to store order email
    ];

    protected $casts = [
        'shipping' => 'array',
        'billing'  => 'array',
    ];
}
