<div>
<!-- Breadcrumb Start Here -->
<div class="breadcrumb">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb--wrapper">
                    <h2 class="breadcrumb--title fw--400">  Cart </h2>
                    <ul class="breadcrumb--list">
                        <li class="breadcrumb--item"><a href="{{ url('/') }}" class="breadcrumb--link">Home</a></li>
                        <li class="breadcrumb--icon">/</li>
                        <li class="breadcrumb--item"> <span class="breadcrumb--item--text"> Cart </span> </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb End Here -->

<section class="all-cart--list py-10">
    <div class="container">
        <div class="row border-bottom--solid1 d-none d-md-flex">
            <div class="col-lg-6 col-md-6">
                <h6>Product</h6>
            </div>
            <div class="col-lg-2 col-md-2">
                <h6>Price</h6>
            </div>
            <div class="col-lg-2 col-md-2">
                <h6>Quantity</h6>
            </div>
            <div class="col-lg-2 col-md-2">
                <h6>Total</h6>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-lg-12">
                <div class="product-list border-bottom--solid1">
                    @forelse ($carts as $cart)
                    <div class="row gy-3 align-items-center">
                        <div class="col-lg-6 col-md-6">
                            <div class="content--wrap d-flex align-items-baseline gap--20">
                                <div class="thumb--wrap">
                                    <img src="{{ uploadedFile($cart->product->thumbnail_img) }}" height="100" width="100" alt="{{ $cart->product->name }}">
                                </div>
                                <div class="title--wrap">
                                    <h6 class="fw--400">
                                        {{ $cart->product->name }}
                                    </h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-2 d-none d-md-block">
                            <div class="price--wrap flex-shrink-0">
                                <h6 class="price fw--400">৳{{ $cart->price }}</h6>
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-2 d-flex justify-content-lg-start justify-content-end">
                            <div class="quantity_box border--base d-flex justify-content-center align-items-center">
                                <button type="button" class="sub" wire:click='decreaseQuantity({{ $cart->id }})'><i class="fa fa-minus"></i></button>
                                <input class="count-input" type="number" id="quantityInput" value="{{ $cart->quantity }}" readonly>
                                <button type="button" class="add" wire:click='inreaseQuantity({{ $cart->id }})'><i class="fa fa-plus"></i></button>
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-2 d-flex justify-content-lg-start justify-content-end">
                            <div class="total-price--wrap flex-shrink-0">
                                <h6 class="price fs--20 fw--400">৳{{ $cart->price * $cart->quantity }}</h6>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center">No Data Found</div>
                    @endforelse
                </div>
            </div>

        </div>


        @if(count($carts) > 0)
        <div class="row justify-content-end">
            <div class="col-lg-4 col-md-8">
                <div class="cart--footer2 d-flex flex-column gap--20 justify-content-center align-items-center w--100 position-relative">
                    <div class="d-flex justify-content-between align-items-center w--100">
                        <h6 class="mb-0">Subtotal:</h6>
                        <h6 class="mb-0">৳{{ $carts->sum('total_price') }}</h6>
                    </div>

                    <div class="d-flex flex-column justify-content-center align-items-center gap--12 w--100">
                        <button class="btn btn--base w-100 btn--lg w--100" @click="checkoutModal = true">
                            Proceed To Checkout ({{ count($carts) }})
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
</div>
