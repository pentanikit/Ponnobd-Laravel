<?php

namespace App\Livewire\Frontend\Customer;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Sidebar extends Component
{
    public function placeholder()
    {
        return <<<'HTML'
        <div class="card bg-light w-100" aria-hidden="true">
            <div class="card-body text-center">
                <div class="avatar avatar-xl mb-2 placeholder rounded-circle"></div>
                <h6 class="mb-0 placeholder-glow"></h6>
                <h5 class="card-title placeholder-glow">
                    <span class="placeholder col-6"></span>
                </h5>
                <hr>
                <p class="card-text placeholder-glow p-4 pb-3">
                    <span class="placeholder col-12"></span>
                    <span class="placeholder col-12"></span>
                    <span class="placeholder col-12"></span>
                    <span class="placeholder col-12"></span>
                    <span class="placeholder col-12"></span>
                </p>
            </div>
        </div>
        HTML;
    }

    public function logOut()
    {
        Auth::logout();

        return $this->redirect(route('home'), true);
    }

    public function render()
    {
        return view('livewire.frontend.customer.sidebar');
    }
}
