<?php

namespace App\Livewire\Frontend;

use App\Models\Product;
use Livewire\Component;
use App\Models\DisplaySection;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Cache;

class Index extends Component
{
    public $categoriesSectionReady = false,$keyword;

    public $search_products = [];

    public function getCategoriesSectionProducts()
    {
        $this->categoriesSectionReady = true;
    }

    #[Computed(cache: true)]
    public function sections()
    {
        return DisplaySection::with('products')->orderBy('order')->get();
    }

    public function render()
    {
        if($this->keyword != null){
            $this->search_products = Product::publish()
            ->where('name','LIKE','%'.$this->keyword.'%')
            ->where('description','LIKE','%'.$this->keyword.'%')
            ->topSell()
            ->limit(20)
            ->get();
        }

        return view('livewire.frontend.index')->with('title', config('app.name'));
    }
}
