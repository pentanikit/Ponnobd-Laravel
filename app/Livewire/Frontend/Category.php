<?php

namespace App\Livewire\Frontend;

use App\Models\Brand;
use App\Models\Product;
use Livewire\Component;
use App\Models\Wishlist;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Livewire\Attributes\Locked;
use App\Models\Category as CategoryModel;
use Illuminate\Support\Benchmark;

class Category extends Component
{
    use WithPagination;

    public $filters = [];

    #[Url]
    public $limit = 12;

    #[Url]
    public $sort = 'low';

    #[Url]
    public $availability;

    #[Locked]
    public $category = null;

    #[Url]
    public $brand;

    #[Url]
    public $maxPrice = '';

    #[Url]
    public $minPrice = '';

    public $category_id = null;

    public function mount($slug)
    {
        $this->category = CategoryModel::where('slug', $slug)->firstOrFail();

        $this->category_id = $this->category?->id;
    }

    public function filterClear()
    {
        $this->minPrice = '';
        $this->maxPrice = '';
        $this->availability = '';
        $this->brand = '';
        $this->resetPage();
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

    // public function addToWishlist($product_id)
    // {
    //     $product = Product::find($product_id);

    //     $wishlist = Wishlist::MyWishlists()->where('product_id', $product_id)->first();

    //     if ($product !== null && $wishlist == null) {
    //         Wishlist::create([
    //             'product_id' => $product_id,
    //             'user_id' => auth()->id(),
    //             'guest_id' => guestID(),
    //         ]);

    //         $this->dispatch('wishlist-changed');

    //         $this->dispatch('alert', [
    //             'type' => 'success',
    //             'message' => 'Product added to wishlist!',
    //         ]);

    //         return;
    //     }

    //     $this->dispatch('alert', [
    //         'type' => 'error',
    //         'message' => 'Product already exists to wishlist!',
    //     ]);
    // }

    public function setLimit($limit)
    {
        $this->limit = $limit;
        $this->resetPage();
    }

    public function setBrand($id)
    {
        $this->brand = $id;
    }

    #[On('refresh')]
    public function render()
    {
        $products = Product::publish()
                    ->when($this->sort, function ($query) {
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
                    ->when($this->minPrice || $this->maxPrice, function ($query) {
                        $query->where('unit_price', '>=', $this->minPrice)
                            ->where('unit_price', '<=', $this->maxPrice);
                    })
                    ->when($this->availability, function ($query) {
                        if($this->availability == 'in_stock') {
                            $query->where('current_stock', '>', 0);
                        } else {
                            $query->where('current_stock', '<=', 0);
                        }
                    })->when(count($this->filters) > 0,function($query){
                        foreach ($this->filters as $key => $value) {
                            $key = (string) $key;
                            $value = (string) $value;
                            if (!empty($value)) {
                                $query->whereJsonContains("attributes->$key", $value);
                            }
                        }
                    });

        $attribute_list = Product::query()->when($this->category_id, function ($query) {
            $query->whereHas('categories', function ($categories) {
                $categories->where('category_id', $this->category_id);
            });
        })->pluck('attributes')->reject(function($attribute){
            return is_array($attribute) && count($attribute) == 0 || $attribute === null;
        })->unique();

        // $attributes = collect($attribute_list->reduce(function ($carry, $item) {
        //     foreach ($item as $key => $values) {
        //         if (!isset($carry[$key])) {
        //             $carry[$key] = $values;
        //         } else {
        //             $carry[$key] = array_unique(array_merge($carry[$key], $values));
        //         }
        //     }
        //     return $carry;        
        // }, []))->unique();
        
        $attributes = collect($attribute_list->reduce(function ($carry, $item) {
            
            if(is_array($item)){
                            foreach ($item as $key => $values) {

                if (!isset($carry[$key])) {

                    $carry[$key] = $values;

                } else {

                    $carry[$key] = array_unique(array_merge($carry[$key], $values ?? [] ));

                }

            }

            return $carry;
                
            }


        }, []))->unique();

        return view('livewire.frontend.category', [
            'brands' => Brand::whereIn('id', Product::publish()->when($this->category_id, function ($query) {
                $query->whereHas('categories', function ($categories) {
                    $categories->where('category_id', $this->category_id);
                });
            })->whereNotNull('brand_id')->pluck('brand_id'))->get(),
            'products' => $products->paginate($this->limit),
            'attributes' => $attributes
        ]);

    }
}