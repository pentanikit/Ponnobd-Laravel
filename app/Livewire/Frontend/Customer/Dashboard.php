<?php

namespace App\Livewire\Frontend\Customer;

use App\Models\Cart;
use App\Models\Wishlist;
use Livewire\Attributes\Title;
use Livewire\Component;

class Dashboard extends Component
{
    public $cartsCount;

    public $wishlistsCount;

    public $totalOrdersCount;

    public function mount()
    {
        $this->cartsCount = Cart::MyCarts()->count();
        $this->wishlistsCount = Wishlist::myWishlists()->count();
        $this->totalOrdersCount = count(auth()->user()->orders);
    }

    #[Title('Dashboard')]
    public function render()
    {
        return view('livewire.frontend.customer.dashboard');
    }
}
