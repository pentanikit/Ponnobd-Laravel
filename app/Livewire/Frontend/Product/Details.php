<?php

namespace App\Livewire\Frontend\Product;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Wishlist;
use App\Models\ProductStock;
use App\Models\ProductReview;
use App\Models\Category;
use App\Livewire\Frontend\Inc\Header;

class Details extends Component
{
    public $product;
    public $comment;
    public $rating;
    public $selectedVariations = [];
    public $totalPrice = 0;
    public $related_products;
    public $variationImg = null;

    public function mount($slug)
    {
        $this->product = Product::with('categories.category', 'stocks', 'reviews.user', 'brand')
            ->where('slug', $slug)->publish()->first();

        if ($this->product === null) {
            $category = Category::whereSlug($slug)->first();
            return $category
                ? redirect()->route('shop', ['category' => $slug])
                : abort(404);
        }

        $this->getTotalPrice();

        $this->related_products = Product::whereHas('categories', function ($q) {
            $q->whereIn('category_id', $this->product->categories->pluck('category_id'));
        })->inRandomOrder()->publish()->limit(20)->get();

        // GA4 view_item (named args)
        $i = $this->gaItem();
        $this->dispatch('view-item',
            id:       $i['id'],
            name:     $i['name'],
            brand:    $i['brand'],
            category: $i['category'],
            price:    $i['price'],
            quantity: $i['quantity']
        );
    }

    public function addToWishlist($product_id)
    {
        $product  = Product::with('brand','categories.category')->find($product_id);
        $wishlist = Wishlist::MyWishlists()->where('product_id', $product_id)->first();

        if ($product && !$wishlist) {
            Wishlist::updateOrCreate([
                'product_id' => $product_id,
                'user_id'    => auth()->id(),
                'guest_id'   => guestID(),
            ]);

            $this->dispatch('wishlist-changed')->to(Header::class);

            $this->dispatch('alert', [
                'type'    => 'success',
                'message' => 'Product added to wishlist!',
            ]);

            // GA4 add_to_wishlist (named args)
            $i = $this->gaItem();
            $this->dispatch('add-to-wishlist',
                id:       $i['id'],
                name:     $i['name'],
                brand:    $i['brand'],
                category: $i['category'],
                price:    $i['price'],
                quantity: 1
            );

            return;
        }

        $this->dispatch('alert', [
            'type'    => 'error',
            'message' => 'Product already exists in wishlist!',
        ]);
    }

    public function addToCart($redirect = false)
    {
        $product = $this->product;

        if ($product->variant_product) {
            $attrCount = is_string($product->attributes)
                ? count(json_decode($product->attributes, true) ?? [])
                : (is_array($product->attributes) ? count($product->attributes) : 0);

            if ($attrCount === count($this->selectedVariations)) {
                $price = (float) $this->totalPrice;
                $tax   = $product->tax_type === 'percent'
                    ? ($price * (float) $product->tax) / 100
                    : (float) ($product->tax ?? 0);

                Cart::updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'user_id'    => auth()->id(),
                        'guest_id'   => guestID(),
                    ],
                    [
                        'quantity'      => 1,
                        'variation'     => json_encode($this->selectedVariations),
                        'price'         => $price,
                        'shipping_type' => 'home_delivery',
                        'tax'           => $tax,
                    ]
                );

                $this->dispatch('cart-changed');
                $this->dispatch('alert', [
                    'type'    => 'success',
                    'message' => 'Product added to your cart!',
                ]);

                // GA4 add_to_cart (named args)
                $i = $this->gaItem(quantity: 1);
                $this->dispatch('add-to-cart',
                    id:       $i['id'],
                    name:     $i['name'],
                    brand:    $i['brand'],
                    category: $i['category'],
                    price:    $i['price'],
                    quantity: $i['quantity']
                );

                if ($redirect) {
                    return $this->redirect(route('cart'));
                }
                return;
            }

            $this->dispatch('alert', [
                'type'    => 'warning',
                'message' => 'Please choose all variations!',
            ]);
            return;
        }

        // Non-variant
        $price = (float) $product->discountPrice(false);
        $tax   = 0.0;

        if ($product->tax_type === 'percent') {
            $tax += ($price * (float) $product->tax) / 100;
        } elseif ($product->tax_type === 'amount') {
            $tax += (float) $product->tax;
        }

        Cart::updateOrCreate(
            [
                'product_id' => $product->id,
                'user_id'    => auth()->id(),
                'guest_id'   => guestID(),
            ],
            [
                'quantity'      => 1,
                'price'         => $price,
                'shipping_type' => 'home_delivery',
                'tax'           => $tax,
            ]
        );

        $this->dispatch('cart-changed');
        $this->dispatch('alert', [
            'type'    => 'success',
            'message' => 'Product added to your cart!',
        ]);

        // GA4 add_to_cart (named args)
        $i = $this->gaItem(quantity: 1);
        $this->dispatch('add-to-cart',
            id:       $i['id'],
            name:     $i['name'],
            brand:    $i['brand'],
            category: $i['category'],
            price:    $i['price'],
            quantity: $i['quantity']
        );

        if ($redirect) {
            return $this->redirect(route('cart'));
        }
    }

    // Optional “Buy Now” → also signal begin_checkout
    public function quickBuy()
    {
        $this->addToCart(false);

        $i = $this->gaItem(quantity: 1);

        // begin_checkout expects a cart-like payload
        $this->dispatch('begin-checkout',
            total: (float) ($i['price'] * $i['quantity']),
            items: [[
                'id'       => $i['id'],
                'name'     => $i['name'],
                'brand'    => $i['brand'],
                'category' => $i['category'],
                'price'    => (float) $i['price'],
                'qty'      => (int) $i['quantity'], // your JS maps qty→quantity
            ]]
        );

        return $this->redirect(route('checkout'));
    }

    public function changeRating($rating)
    {
        $this->rating = $rating;
    }

    public function addVariation($variation, $value)
    {
        $this->selectedVariations[$variation] = str_replace(' ', '', trim($value));

        // Recalc price & preview image
        $this->dispatch('getTotalPrice')->self();

        // Refresh GA4 view_item to reflect selected variant price
        $i = $this->gaItem();
        $this->dispatch('view-item',
            id:       $i['id'],
            name:     $i['name'],
            brand:    $i['brand'],
            category: $i['category'],
            price:    $i['price'],
            quantity: $i['quantity']
        );
    }

    #[On('getTotalPrice')]
    public function getTotalPrice()
    {
        if ($this->product->variant_product) {
            $variantKey = collect($this->selectedVariations)->join('-');
            $variation  = ProductStock::where('product_id', $this->product->id)
                ->where('variant', $variantKey)
                ->first();

            $this->totalPrice   = (float) ($variation->price ?? 0);
            $this->variationImg = $variation->image ?? null;
            return;
        }

        $this->totalPrice = (float) $this->product->discountPrice(false);
    }

    public function addReview()
    {
        $this->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);

        $review             = new ProductReview();
        $review->product_id = $this->product->id;
        $review->user_id    = auth()->id();
        $review->comment    = $this->comment;
        $review->rating     = (int) $this->rating;
        $review->save();

        $this->reset(['rating','comment']);

        $this->dispatch('alert', [
            'type'    => 'success',
            'message' => 'Review has been added!',
        ]);

        // review_submitted (named args)
        $this->dispatch('review-submitted',
            product_id: (string) $this->product->id,
            rating:     (int) $review->rating
        );
    }

    public function render()
    {
        return view('livewire.frontend.product.details')
            ->with('title', $this->product->name);
    }

    /**
     * Build a GA4-friendly item payload.
     */
    private function gaItem(int $quantity = 1): array
    {
        $brand    = optional($this->product->brand)->name;
        $category = optional(optional($this->product->categories->first())->category)->name;

        $price = $this->product->variant_product
            ? (float) $this->totalPrice
            : (float) $this->product->discountPrice(false);

        return [
            'id'       => (string) $this->product->id,
            'name'     => $this->product->name,
            'brand'    => $brand,
            'category' => $category,
            'price'    => $price,
            'quantity' => $quantity,
        ];
    }
}
