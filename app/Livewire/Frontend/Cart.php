<?php

namespace App\Livewire\Frontend;

use App\Livewire\Frontend\Inc\Header;
use App\Models\Cart as CartModel;
use Livewire\Attributes\Title;
use Livewire\Component;

class Cart extends Component
{
    public $carts;

    public function mount()
    {
        $this->getCarts();
    }

    public function getCarts()
    {
        $this->carts = CartModel::with('product')->latest()->myCarts()->get();
    }

    public function updateShipping($value)
    {
        CartModel::with('product')->latest()->myCarts()->update([
            'shipping_type' => $value,
        ]);
    }

    public function deleteFromCart($product_id)
    {
        try {
            $cart = CartModel::myCarts()->where('product_id', $product_id)->first();

            $cart->delete();
            $this->dispatch('cart-changed')->to(Header::class);
            $this->dispatch('alert', [
                'type' => 'success',
                'message' => 'Product removed from your cart!',
            ]);

            $this->getCarts();

        } catch (\Throwable $th) {
            $this->dispatch('alert', [
                'type' => 'success',
                'message' => 'Sorry, Something went wrong!',
            ]);
        }

    }

    public function inreaseQuantity($cart_id)
    {
        try {
            $cart = CartModel::find($cart_id);

            $cart->increment('quantity');
            $this->getCarts();
            $this->dispatch('cart-changed')->to(Header::class);

        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function decreaseQuantity($cart_id)
    {
        try {
            $cart = CartModel::find($cart_id);
            if ($cart->quantity != 0 && $cart->quantity >= 2) {
                $cart->decrement('quantity');
                $this->getCarts();
                $this->dispatch('cart-changed')->to(Header::class);
            }

        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    #[Title('Cart')]
    public function render()
    {
        return view('livewire.frontend.cart');
    }
}
