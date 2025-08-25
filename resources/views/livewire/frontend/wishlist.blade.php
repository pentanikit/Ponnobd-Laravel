<div>
    <!-- breadcrumb section -->
    <section class="breadcrumb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread d-flex justify-content-center">
                        <ul>
                            <li><a href="{{ url('/') }}">Home </a></li>
                            <li><a>/ Wishlist</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb section -->
    <!-- wishlist table -->
    <section class="wishlisttable">
        <div class="container table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td></td>
                        <td>Product</td>
                        <td>Price</td>
                        <td>Status</td>
                        <td width="200px">Action</td>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($wishlists as $wishlist)
                    @php
                        $product = $wishlist->product;
                    @endphp
                    <tr wire:key='{{ $product->id }}' wire:target='deleteFromWishlist({{ $product->id }})' wire:loading.class='row-disabled'>
                        <td>
                            <a class="tax bi bi-x" wire:click='deleteFromWishlist({{ $product->id }})' href="javascript:void(0)"></a>
                        </td>
                        <td>
                            <a class="taimg" href="{{ route('product.details',$product->slug) }}" wire:navigate>
                                <img src="{{ uploadedFile($product->thumbnail_img) }}" alt="">
                            </a>
                            <a href="{{ route('product.details',$product->slug) }}" wire:navigate class="tatile" href="">{{ $product->name }}</a>
                        </td>
                        <td><span class="price">{{ $product->discountPrice() }}</span></td>
                        <td>
                            <span class="badge bg-success">In Stock</span>
                        </td>
                        <td>
                            <div class="d-flex">
                                @if(!$product->variant_product)
                                <a class="taaddcart" href="javascript:void(0)" wire:click='addToCart({{ $product->id }})'>Add to cart</a>
                                @endif
                                <a class="tabuynow ml-2" href="{{ route('product.details',$product->slug) }}" wire:navigate><div class="bi bi-eye"></div></a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <td colspan="5">No products added to the wishlist.</td>
                    @endforelse
                </tbody>
            </table>
            {{-- <div class="row "> --}}
                {{-- @forelse ($wishlists as $wishlist)
                <livewire:frontend.inc.wishlist-product-box :product="$wishlist->product">
                @empty
                <div class="text-center">No products added to the wishlist.</div>
                @endforelse --}}
                {{-- @forelse ($wishlists as $wishlist)
                @php
                    $product = $wishlist->product;
                @endphp
                <div class="col-lg-3 col-md-4 col-6" wire:key='{{ $product->id }}'>
                    <div class="product-wrapper">
                        <div class="ptoduct-img"> <span class="new">New</span>
                            <a href=""><img src="{{ uploadedFile($product->thumbnail_img) }}" alt="{{ $product->name }}"></a>
                            <div class="icon-box">
                                <div class="icons">
                                    <a class="bi bi-trash cursor-pointer" wire:target='deleteFromWishlist({{ $product->id }})' wire:loading.class.remove='bi bi-heart' wire:loading.class='bi bi-arrow-repeat' wire:click='deleteFromWishlist({{ $product->id }})'></a>

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
                @empty
                <div class="text-center">No products added to the wishlist.</div>
                @endforelse --}}
            {{-- </div> --}}
        </div>
    </section>
    <!-- wishlist table -->
</div>
