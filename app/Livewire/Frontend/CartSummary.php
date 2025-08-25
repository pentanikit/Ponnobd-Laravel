<?php

namespace App\Livewire\Frontend;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\OrderDetails;
use App\Mail\OrderPlacedMail;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Livewire\Frontend\Inc\Header;

class CartSummary extends Component
{
    public $carts;

    public $name = '';
    public $phone = '';
    public $address = '';
    public $notes = '';
    public $shipping_type = 'inside_dhaka';

    public function mount()
    {
        $this->carts();
    }

    public function carts()
    {
        $this->carts = Cart::with('product')->latest()->myCarts()->get();
    }

    public function save()
    {
        $validated = $this->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'notes' => 'nullable',
            'shipping_type' => 'required'
        ]);

        try {

            DB::beginTransaction();

            $shippingAddress = [
                'full_name' => $this->name,
                'address' => $this->address,
                'phone' => $this->phone,
                'shipping_type' => $this->shipping_type,
                'notes' => $this->notes,
            ];

            $price = 0;

            $order = Order::create([
                'user_id' => auth()->id(),
                'guest_id' => guestID(),
                'note' => $this->notes,
                'code' => date('YHis').rand(10, 99),
                'shipping' => json_encode($shippingAddress),
                'billing' => json_encode($shippingAddress),
                'payment_type' => 'cash_on_delivery',
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'status' => 'pending',
            ]);

            $inside_dhaka_cost = collect($this->carts)->map(function($cart){
                $type = json_decode($cart->product->shipping_type);
                return data_get($type,'inside_dhaka',0);
            })->sum();
            $outside_dhaka_cost = collect($this->carts)->map(function($cart){
                $type = json_decode($cart->product->shipping_type);
                return data_get($type,'outside_dhaka',0);
            })->sum();

            $shipping_charge = $this->shipping_type == 'inside_dhaka' ? $inside_dhaka_cost : $outside_dhaka_cost;

            foreach ($this->carts as $cart) {
                $price += $cart->price * $cart->quantity;
                $product = Product::find($cart->product_id);
                $product->increment('num_of_sale');
                OrderDetails::create([
                    'order_id' => $order->id,
                    'seller_id' => $cart->product?->user_id,
                    'product_id' => $cart->product_id,
                    'created_via' => 'laravel',
                    'price' => $cart->price,
                    'variation' => $cart->variation,
                    'quantity' => $cart->quantity,
                    'shipping_type' => $this->shipping_type,
                    'shipping_cost' => $this->shipping_type == 'inside_dhaka' ? $inside_dhaka_cost : $outside_dhaka_cost,
                    'status' => 'pending',
                ]);

                Cart::destroy($cart->id);
            }

            $order->total = $price + $shipping_charge;
            $order->save();

            DB::commit();

            $emails = explode(',',settings('order_placed_emails'));
            
            try {
                Mail::to($emails)->send(new OrderPlacedMail($order));
            } catch (\Throwable $th) {
            }

            return $this->redirect(route('order.success', encrypt($order->id)));

        } catch (\Throwable $th) {
            DB::rollBack();

            session()->flash('error','Sorry, something went wrong!');

            return $this->redirect(route('cart'));
        }

    }

    public function inreaseQuantity($cart_id)
    {
        try {
            $cart = Cart::find($cart_id);

            $cart->increment('quantity');
            $this->carts();
            $this->dispatch('cart-changed')->to(Header::class);

        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function decreaseQuantity($cart_id)
    {
        try {
            $cart = Cart::find($cart_id);
            if ($cart->quantity != 0 && $cart->quantity >= 1) {
                $cart->decrement('quantity');
                $this->carts();
                $this->dispatch('cart-changed')->to(Header::class);
            }

        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function deleteFromCart($product_id)
    {
        try {
            $cart = Cart::myCarts()->where('product_id', $product_id)->first();

            $cart->delete();
            $this->dispatch('cart-changed')->to(Header::class);
            $this->dispatch('alert', [
                'type' => 'success',
                'message' => 'Product removed from your cart!',
            ]);

            $this->carts();

        } catch (\Throwable $th) {
            $this->dispatch('alert', [
                'type' => 'error',
                'message' => 'Sorry, Something went wrong!',
            ]);
        }

    }

    public function render()
    {
        return view('livewire.frontend.cart-summary');
    }
}
