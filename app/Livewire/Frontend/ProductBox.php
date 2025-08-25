<?php

namespace App\Livewire\Frontend;

use App\Livewire\Frontend\Inc\Header;
use App\Models\Product;
use App\Models\Wishlist;
use Livewire\Component;

class ProductBox extends Component
{
    public $product;

    public function mount($product)
    {
        $this->product = $product;
    }

    public function placeholder()
    {
        return view('livewire.frontend.inc.product-placeholder');
    }

    public function addToWishlist($product_id)
    {
        $product = Product::find($product_id);

        $wishlist = Wishlist::MyWishlists()->where('product_id', $product_id)->first();

        if ($product !== null && $wishlist == null) {
            Wishlist::create([
                'product_id' => $product_id,
                'user_id' => auth()->id(),
                'guest_id' => guestID(),
            ]);

            $this->dispatch('wishlist-changed')->to(Header::class);

            $this->dispatch('alert', [
                'type' => 'success',
                'message' => 'Product added to wishlist!',
            ]);

            return;
        }

        $this->dispatch('alert', [
            'type' => 'error',
            'message' => 'Product already exists to wishlist!',
        ]);
    }

    public function render()
    {
        return view('livewire.frontend.product-box');
    }
}
