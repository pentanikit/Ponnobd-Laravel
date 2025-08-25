<?php

namespace App\Livewire;

use App\Models\Cart;
use Livewire\Component;
use Livewire\Attributes\On;


class MobileMenu extends Component
{
    public $cartCount = 0;

    #[On('cart-changed')]
    public function getCartCount()
    {
        $carts = Cart::query()->myCarts()->get();
        $this->cartCount = $carts->count();
    }

    public function mount()
    {
        $this->getCartCount();
    }

    public function render()
    {
        return view('livewire.mobile-menu');
    }
}
