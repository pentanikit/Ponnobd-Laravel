<?php

namespace App\Livewire\Frontend\Inc;

use App\Models\Wishlist as WishlistModel;
use Livewire\Component;

class WishlistProductBox extends Component
{
    public $product;

    public function placeholder()
    {
        return view('livewire.frontend.inc.product-placeholder');
    }

    public function mount($product)
    {
        $this->product = $product;
    }

    public function deleteFromWishlist($product_id)
    {
        $wishlist = WishlistModel::MyWishlists()->where('product_id', $product_id)->first();

        $wishlist->delete();
        $this->dispatch('wishlist-changed')->to(Header::class);

        $this->dispatch('alert', [
            'type' => 'success',
            'message' => 'Item has been removed from wishlist!',
        ]);

    }

    public function render()
    {
        return view('livewire.frontend.inc.wishlist-product-box');
    }
}
