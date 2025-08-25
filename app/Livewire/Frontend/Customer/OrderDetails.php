<?php

namespace App\Livewire\Frontend\Customer;

use App\Models\Order;
use Livewire\Component;

class OrderDetails extends Component
{
    public $order;

    public function mount($id)
    {
        $this->order = Order::findOrFail(decrypt($id));
    }

    public function render()
    {
        return view('livewire.frontend.customer.order-details');
    }
}
