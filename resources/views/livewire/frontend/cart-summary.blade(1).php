<div>
    <div class="cart-box animate__backInRight" :class="cartSummaryOpened ? 'show-cart-box' : ''">
        <button class="close--btn"><i class="fa-solid fa-xmark"></i></button>
    
        <div class="cart-item--wrap">
            @forelse ($carts as $cart)
            <div class="cart-item-card">
                <div class="thumb">
                    <img src="{{ uploadedFile($cart->product->thumbnail_img) }}" alt="...">
                </div>
                <div class="content">
                    <a href="#">
                        <h6 class="fs--14 title">
                            {{ $cart->product->name }}
                        </h6>
                    </a>
                    <p class="price text--black">{{ formatPrice($cart->quantity*$cart->price) }}</p>
                    <div class="user-cta d-flex jus align-items-center">
                        <div class="quantity_box diplay_flex">
                            <button type="button" class="sub" wire:click='decreaseQuantity({{ $cart->id }})'><i class="fa fa-minus"></i></button>
                            <input class="count-input" type="number" id="quantityInput" value="{{ $cart->quantity }}" readonly>
                            <button type="button" class="add" wire:click='inreaseQuantity({{ $cart->id }})'><i class="fa fa-plus"></i></button>
                        </div>
                        <button class="trash-btn" wire:click='deleteFromCart({{ $cart->product_id }})'>Remove</button>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center">{{ __('Cart is empty') }}</div>
            @endforelse
        </div>
        @if(count($carts) > 0)
        <div class="cart--footer d-flex flex-column gap--20 justify-content-center align-items-center w--100 position-absolute">
            <div class="d-flex justify-content-between align-items-center w--100">
                <h6 class="mb-0">Subtotal:</h6>
                <h6 class="mb-0">৳{{ $carts->sum('total_price') }}</h6>
            </div>
    
            <div class="d-flex flex-column justify-content-center align-items-center gap--12 w--100">
                <button class="btn btn--base w-100 btn--lg w--100" @click="checkoutModal = true">
                    Proceed To Checkout ({{ count($carts) }})</button>
                <a href="{{ route('cart') }}" class="text-decoration-underline">View Cart</a>
            </div>
        </div>
        @endif
    </div>

    <!-- modal wrap -->
    <div class="modal modal--base fade" x-transition.duration.500ms :class="checkoutModal ? 'show' : '' " :style="checkoutModal ? 'display:block;  background: rgba(0,0,0,0.5);' : 'display:none'" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="title fs--24 fw--600">Enter your information</h6>
                    <button type="button" class="btn--close" @click="checkoutModal = false"><i
                            class="fa-solid fa-xmark"></i></button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center gy-4">
                        <div class="col-lg-12">
                            <form wire:submit='save'>
                                <!-- user info -->
    
                                <div class="input--wrap mb-2 d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Name</h6>
                                    <div class="input-group  w--80">
                                        <span class="input-group-text" id="basic-addon1"><i
                                                class="fa-solid fa-user"></i></span>
                                        <input type="text" class="form-control form--control border-left--none @error('name') is-invalid border-2 @enderror"
                                            placeholder="Name" wire:model='name'>
                                    </div>
                                </div>

                                @error('name')
                                <div class="text-danger text-center mt-2 mb-2">
                                    {{ $message }}
                                </div>
                                @enderror
    
                                <div class="input--wrap mb-2 d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Phone</h6>
                                    <div class="input-group w--80">
                                        <span class="input-group-text" id="basic-addon1"><i
                                                class="fa-solid fa-phone"></i></span>
                                        <input type="number" class="form-control form--control border-left--none @error('phone') is-invalid border-2 @enderror"
                                            placeholder="+880 000 00 00 000" wire:model='phone'>
                                    </div>
                                </div>
                                @error('phone')
                                <div class="text-danger text-center mt-2 mb-2">
                                    {{ $message }}
                                </div>
                                @enderror
    
                                <div class="input--wrap mb-2 d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">Address</h6>
                                    <div class="input-group w--80">
                                        <span class="input-group-text" id="basic-addon1"><i
                                                class="fa-solid fa-location-dot"></i></span>
                                        <input type="text" class="form-control form--control border-left--none @error('address') is-invalid border-2 @enderror"
                                            wire:model='address'>
                                    </div>
                                </div>
                                @error('address')
                                <div class="text-danger text-center mt-2 mb-2">
                                    {{ $message }}
                                </div>
                                @enderror
                                @php
                                    $inside_dhaka_cost = collect($carts)->map(function($cart){
                                        $type = json_decode($cart->product->shipping_type);
                                        return data_get($type,'inside_dhaka',0);
                                    })->sum();
                                    $outside_dhaka_cost = collect($carts)->map(function($cart){
                                        $type = json_decode($cart->product->shipping_type);
                                        return data_get($type,'outside_dhaka',0);
                                    })->sum();

                                    $shipping_cost = $shipping_type == 'inside_dhaka' ? $inside_dhaka_cost : $outside_dhaka_cost
                                @endphp
                                <div class="mb-3">
                                    <h6>Shipping Method</h6>
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="form--radio">
                                                    <input class="form-radio-input filter-by-category" wire:model.live='shipping_type' type="radio" value="inside_dhaka" id="inside_dhaka">
                                                    <label class="form-check-label" for="inside_dhaka">
                                                        Inside Dhaka
                                                    </label>
                                                </div>
                                                <div class="price">
                                                    <p class="fs--18 fw--700">৳{{ $inside_dhaka_cost }}</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="form--radio">
                                                    <input class="form-radio-input filter-by-category" wire:model.live='shipping_type' type="radio" value="outside_dhaka" id="outside_dhaka">
                                                    <label class="form-check-label" for="outside_dhaka">
                                                        Outside Dhaka
                                                    </label>
                                                </div>
                                                <div class="price">
                                                    <p class="fs--18 fw--700">৳{{ $outside_dhaka_cost }}</p>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <!-- user info -->
                                <!-- cart product list -->
                                <div class="product-list--wrap d-flex flex-column gap--16 mb-3">
                                    @forelse ($carts as $cart)
                                    <div class="order-product--card d-flex justify-content-between align-items-center gap--16">
                                        <div class="thumb--wrap position-relative flex-shrink-0">
                                            <img class="fit--img" src="{{ uploadedFile($cart->product->thumbnail_img) }}" alt="{{ $cart->product->name }}">
                                            <div
                                                class="count position-absolute d-flex justify-content-center align-items-center">
                                                <p class="text--white fw--600 text--sm">{{ $cart->quantity }}</p>
                                            </div>
                                        </div>
                                        <div class="content--wrap">
                                            <div class="title">
                                                <h6 class="fs--14 mb-0">
                                                    {{ $cart->product->name }}
                                                </h6>
                                            </div>
                                        </div>
                                        <div>
                                            <button class="fs--24"><i class="fa-solid fa-xmark"></i></button>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="text-center">{{ __('Cart is empty.') }}</div>
                                    @endforelse
                                </div>
                                <!-- cart product list -->
    
                                <!-- Note -->
                                <div
                                    class="note d-flex flex-column justify-content-start align-items-start mb-3 w--100">
                                    <h6 class="">Order Note (Optional)</h6>
                                    <div class="w--100 d-flex justify-content-between">
                                        <input type="text" class="form--control w--100" wire:model='notes' placeholder="Notes">
                                    </div>
                                </div>
                                <!-- Note -->
    
                                <!-- total price -->
                                <div class="mb-3">
                                    <h6>Price</h6>
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="text">
                                                    <p class="text--black">Subtotal</p>
                                                </div>
                                                <div class="price">
                                                    <p class="fs--18 fw--700 text--black">৳{{ $carts->sum('total_price') + $shipping_cost  }}</p>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <!-- total price -->
    
                                <div class="d-flex justify-content-center mb-3">
                                    <button type="submit" class="btn btn--base btn--lg mt-3 text-center w-100" wire:loading.remove wire:target='save'>Click to confirm your order</button>
                                    <button type="submit" class="btn btn--base btn--lg mt-3 text-center w-100" wire:loading wire:target='save'>Order Processing...</button>
                                </div>
    
                                <div class="warnint--text">
                                    <h6 class="text--warning text-center fw--700">By clicking on the button above, your
                                        order will be confirmed immediately!</h6>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
    
            </div>
        </div>
    </div>
    <!-- modal wrap -->
</div>
