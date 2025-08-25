<?php

namespace App\Livewire\Frontend;

use App\Models\Brand;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use App\Models\Wishlist;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use App\Livewire\Frontend\Inc\Header;

class Shop extends Component
{
    use WithPagination;

    #[Url]
    public $limit = 12;

    #[Url]
    public $sort = 'low';

    #[Url]
    public $availability;

    public $category = null;

    #[Url]
    public $brand;

    #[Url]
    public $maxPrice;

    #[Url]
    public $minPrice;

    #[Url]
    public $query = null;

    public $category_id = null;

    public function changeCategory($slug)
    {
        return $this->redirect(route('product.details', $slug));
    }

    public function filterClear()
    {
        $this->resetExcept('limit', 'sort', 'category', 'category_id');
    }

    public function changeBrand(int $brand)
    {
        $this->brand = $brand;
    }

    public function setAvailability($availability)
    {
        $this->availability = $availability;
    }

    public function sortBy($sort)
    {
        $this->sort = match ($sort) {
            'oldest' => 'oldest',
            'latest' => 'latest',
            'low' => 'low',
            'high' => 'high',
            'popularity' => 'popularity'
        };
    }

    public function addToWishlist($product_id)
    {
        $product = Product::find($product_id);

        $wishlist = Wishlist::MyWishlists()->where('product_id', $product_id)->first();

        if ($product !== null && $wishlist == null) {
            Wishlist::create([
                'product_id' => $product_id,
                'user_id' => auth()->id(),
                'guest_id' => guestID(),
            ]);

            $this->dispatch('wishlist-changed');

            $this->dispatch('alert', [
                'type' => 'success',
                'message' => 'Product added to wishlist!',
            ]);

            return;
        }

        $this->dispatch('alert', [
            'type' => 'error',
            'message' => 'Product already exists to wishlist!',
        ]);
    }

    public function setLimit($limit)
    {
        $this->limit = $limit;
        $this->resetPage();
    }

    public function updatingCategory()
    {
        $this->resetPage();
    }


    #[On('refresh')]
    public function render()
    {

        $products = Product::publish()->when($this->sort, function ($query) {
            $query->when($this->sort == 'popularity', fn ($query) => $query->topSell());
            $query->when($this->sort == 'latest', fn ($query) => $query->latest());
            $query->when($this->sort == 'oldest', fn ($query) => $query->oldest());
            $query->when($this->sort == 'low', fn ($query) => $query->orderByPrice());
            $query->when($this->sort == 'high', fn ($query) => $query->orderByPrice('desc'));
        })
                    ->when($this->category_id, function ($query) {
                        $query->whereHas('categories', function ($categories) {
                            $categories->where('category_id', $this->category_id);
                        });
                    })
                    ->when($this->brand, fn ($query) => $query->where('brand_id', $this->brand))
                    ->when($this->query, function ($query) {
                        $query->where('name', 'LIKE', "%{$this->query}%")
                            ->orWhere('tags', 'LIKE', "%{$this->query}%");
                    })
                    ->when($this->minPrice, function ($query) {
                        $query->where('unit_price', '>=', $this->minPrice)->where('unit_price', '<=', $this->maxPrice);
                    })->when($this->availability, function ($query) {
                        if($this->availability == 'in_stock') {
                            $query->where('current_stock', '>', 0);
                        } else {
                            $query->where('current_stock', '<', 0);
                        }
                    });

        return view('livewire.frontend.shop', [
            'brands' => Brand::whereIn('id', $products->get()->pluck('brand_id'))->get(),
            'categories' => Category::withCount('products')->get(),
            'products' => $products->paginate($this->limit),
        ])->title($this->category->name ?? 'Shop');

    }

}
