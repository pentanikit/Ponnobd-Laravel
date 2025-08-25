<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;

class OrderSuccess extends Component
{
    public $order;

    public function mount($order_id)
    {
        $this->order = Order::with('orderDetails')->find(decrypt($order_id));
    }

    public function render()
    {
        return view('livewire.order-success');
    }
}
