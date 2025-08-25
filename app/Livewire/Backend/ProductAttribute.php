<?php

namespace App\Livewire\Backend;

use App\Models\Attribute;
use Livewire\Component;

class ProductAttribute extends Component
{
    public $attribute_ids = [];

    public function placeholder()
    {
        return <<<'HTML'
        <h3> Loading...</h3>
        HTML;
    }

    public function render()
    {
        return view('livewire.backend.product-attribute', [
            'attributes' => Attribute::all(),
        ]);
    }
}
