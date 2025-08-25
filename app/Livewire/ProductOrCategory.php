<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use Livewire\Attributes\Locked;

class ProductOrCategory extends Component
{
    #[Locked]
    public $type = 'product';
    #[Locked]
    public $slug = '';

    public $product = null;

    #[Locked]
    public $category = null;

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->product = Product::with('categories.category', 'stocks', 'reviews.user')->where('slug', $slug)->publish()->first();

        if($this->product == null ){
            $this->type = 'category';
            $this->category = Category::whereSlug($slug)->firstOrFail();
        }
    }
    public function render()
    {
        $title = $this->type == 'product' ? $this->product?->meta_title : $this->category?->meta_title;
        return view('livewire.product-or-category')->title($title);
    }
}
