<?php

namespace App\Livewire\Frontend;


use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\State;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Title;
use Livewire\Component;

class Checkout extends Component
{
    #[Locked]
    public $carts;

    public $check_terms;

    public $password;

    public $create_account;

    public $name;

    public $address;

    public $phone;

    public $notes;

    protected $rules = [
        'name' => 'required',
        'address' => 'required',
        'phone' => 'required',
        'check_terms' => 'required'
    ];

    public function mount()
    {
        $this->getCarts();

        if (count($this->carts) == 0) {
            return $this->redirect(route('cart'), true);
        }
    }

    public function save()
    {
        if ($this->create_account) {
            $this->rules['phone'] = 'unique:users';
            $this->rules['password'] = 'required|min:6';
        }

        $validated = $this->validate();

        try {

            DB::beginTransaction();

            $shippingAddress = [
                'full_name' => $this->name,
                'address' => $this->address,
                'phone' => $this->phone,
            ];

            if ($this->create_account) {

                $generateUsername = $this->name;

                $user = User::create([
                    'name' => $this->name,
                    'phone' => $this->phone,
                    'password' => bcrypt($this->password),
                    'user_type' => 'customer',
                    'username' => User::whereUsername($generateUsername)->first() ? strtolower($generateUsername.Str::random(4)) : strtolower($generateUsername),
                ]);

                Auth::login($user);
            }

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
                    'shipping_type' => $cart->shipping_type,
                    'status' => 'pending',
                ]);

                Cart::destroy($cart->id);
            }

            $order->total = $price;
            $order->save();

            DB::commit();



            return $this->redirect(route('order.success', encrypt($order->id)));

        } catch (\Throwable $th) {
            DB::rollBack();

            session()->flash('error','Sorry, something went wrong!');

            return $this->redirect(route('cart'));
        }

    }

    public function updateShipping($value)
    {
        Cart::with('product')->latest()->myCarts()->update([
            'shipping_type' => $value,
        ]);
    }

    public function getCarts()
    {
        $this->carts = Cart::with('product')->latest()->myCarts()->get();
    }

    #[Title('Checkout')]
    public function render()
    {
        return view('livewire.frontend.checkout');
    }
}
