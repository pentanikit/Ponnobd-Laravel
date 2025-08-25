<?php

namespace App\Livewire\Frontend\Inc;

use App\Models\Cart;
use App\Models\CategoryMenu;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\On;
use Livewire\Component;

class Header extends Component
{
    public $wishlistCount = 0;

    public $cartCount = 0;

    public $cartPrices = 0;

    public function mount()
    {
        $this->getWishlistCount();
        $this->getCartCount();
    }

    #[On('wishlist-changed')]
    public function getWishlistCount()
    {
        $count = Wishlist::query()->MyWishlists()->count();

        $this->wishlistCount = $count;
    }

    #[On('cart-changed')]
    public function getCartCount()
    {
        $carts = Cart::query()->myCarts()->get();

        $totalPrices = 0;
        foreach ($carts as $cart) {
            $totalPrices += $cart->price * $cart->quantity;
        }
        $this->cartPrices = $totalPrices;
        $this->cartCount = $carts->count();
    }

    public function logOut()
    {
        Auth::logout();

        $this->getWishlistCount();
        $this->getCartCount();

        return $this->redirect(route('home'));
    }

    public function render()
    {
        $categories_menu = Cache::rememberForever('categories-menu',function(){
            return CategoryMenu::with('parents')->oldest()->whereNull('parent_id')->get();
        });

        return view('livewire.frontend.inc.header',[
            'categories_menu' => $categories_menu
        ]);
    }
}
