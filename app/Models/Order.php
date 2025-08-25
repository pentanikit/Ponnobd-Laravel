<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function scopeOwn(Builder $query)
    {
        $query->where('user_id', auth()->id());
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function detail()
    {
        return $this->hasMany(OrderDetails::class, 'order_id', 'id');
    }

    protected $fillable = [
        'user_id',
        'guest_id',
        'note',
        'code',
        'shipping',
        'billing',
        'payment_type',
        'total',
        'ip_address',
        'user_agent',
        'status',
    ];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class, 'order_id', 'id');
    }

    protected $casts = [
        'shipping' => 'array',
        'billing' => 'array',
    ];
}
