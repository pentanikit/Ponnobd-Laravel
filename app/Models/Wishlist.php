<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function scopeMyWishlists(Builder $query)
    {
        $query->when(! auth()->check(), function ($query) {
            $query->where('guest_id', guestID());
        })->when(auth()->check(), function ($query) {
            $query->where('user_id', auth()->id());
        });
    }

    protected $fillable = ['product_id', 'user_id', 'guest_id'];
}
