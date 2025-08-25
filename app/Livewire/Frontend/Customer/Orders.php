<?php

namespace App\Livewire\Frontend\Customer;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class Orders extends Component
{
    use WithPagination;

    public function mount()
    {
        // $this->orders = ;
    }

    public function render()
    {
        return view('livewire.frontend.customer.orders', [
            'orders' => Order::Own()->latest()->paginate(),
        ]);
    }
}
