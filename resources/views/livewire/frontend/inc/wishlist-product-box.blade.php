<div class="col-lg-3 col-md-4 col-6" wire:key='{{ $product->id }}'>
    <div class="product-wrapper">
        <div class="ptoduct-img"> <span class="new">New</span>
            <a href=""><img src="{{ uploadedFile($product->thumbnail_img) }}" alt="{{ $product->name }}"></a>
            <div class="icon-box">
                <div class="icons">
                    <a class="bi bi-trash cursor-pointer" wire:loading.class.remove='bi bi-heart' wire:loading.class='bi bi-arrow-repeat' wire:click='deleteFromWishlist({{ $product->id }})'></a>

                    <a class="bi bi-eye cursor-pointer"></a>
                </div>
            </div> <a href="" class="add-to-cart"><i class="bi bi-basket2-fill"></i> Add to cart</a> </div>
        <div class="title-wrp">
            <a href="">
                <h2 class="product-title">{{ $product->name }}</h2>
            </a>
            <span class="price">
                @if(($homePrice = $product->homePrice()) != ($discountPrice = $product->discountPrice()))
                <del>{{ $homePrice }}</del>
                @else
                <b>{{ $discountPrice }}</b>
                @endif
            </span>
        </div>
    </div>
</div>
