<?php

namespace App\Livewire\Frontend;

use App\Livewire\Frontend\Inc\Header;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Wishlist as WishlistModel;
use Livewire\Attributes\Title;
use Livewire\Component;

class Wishlist extends Component
{
    public $wishlists;

    public function mount()
    {
        $this->getWishlists();
    }

    public function getWishlists()
    {
        $wishlists = WishlistModel::with('product')->latest()->MyWishlists()->get();
        $this->wishlists = $wishlists;
    }

    public function addToCart($product_id)
    {
        $product = Product::find($product_id);

        $tax = 0;
        $price = $product->discountPrice(false);

        if ($product->tax_type == 'percent') {
            $tax += ($price * $product->tax) / 100;
        } elseif ($product->tax_type == 'amount') {
            $tax += $product->tax;
        }

        $cart = Cart::updateOrCreate([
            'product_id' => $product_id,
            'user_id' => auth()->id(),
            'guest_id' => guestID(),
        ], [
            'quantity' => 1,
            'price' => $price,
            'shipping_type' => 'home_delivery',
            'tax' => $tax,
        ]);
        $this->dispatch('cart-changed');

        $this->dispatch('alert', [
            'type' => 'success',
            'message' => 'Product added to your cart!',
        ]);

    }

    public function deleteFromWishlist($product_id)
    {

        try {
            $wishlist = WishlistModel::MyWishlists()->where('product_id', $product_id)->first();

            $wishlist->delete();
            $this->getWishlists();

            $this->dispatch('wishlist-changed')->to(Header::class);

            $this->dispatch('alert', [
                'type' => 'success',
                'message' => 'Item has been removed from wishlist!',
            ]);

        } catch (\Throwable $th) {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => 'Product not found in wishlist!',
            ]);
        }

    }

    #[Title('Wishlist')]
    public function render()
    {
        return view('livewire.frontend.wishlist');
    }
}
