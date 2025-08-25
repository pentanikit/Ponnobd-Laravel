@section('meta')
<meta property="title" content="{{ $product->name }} | {{ config('app.name') }}" />
<meta name="keywords" content="{{ $product->tags }}" />
<meta property="og:title" content="{{ $product->name }} | {{ config('app.name') }}" />
<meta property="og:description" content="{{ strip_tags($product->meta_description) }}" />
<meta name="description" content="{{ strip_tags($product->meta_description) }}" />
<meta property="og:image" content="{{ uploadedFile($product->thumbnail_img) }}" />
<meta property="og:image:secure_url" content="{{ uploadedFile($product->thumbnail_img) }}" />
<meta property="og:image:alt" content="{{ $product->name }} | {{ config('app.name') }}" />
<meta name="twitter:title" content="{{ $product->name }} | {{ config('app.name') }}" />
<meta name="twitter:description" content="{{ strip_tags($product->meta_description) }}" />
<meta name="twitter:image" content="{{ uploadedFile($product->thumbnail_img) }}" />
@endsection


<div>
    <section class="product-details bg--white py-50">
        <div class="container">
            @php
                $photos = json_decode($product->photos);
                $galleries_alt = $product->galleries_alt !== null ? explode(',',$product->galleries_alt) : [];
            @endphp
            <div class="row gy-4 mb-2">
                <div class="col-xxl-6 col-xl-7 col-lg-7">
                    <div class="row gy-4 flex-wrap-reverse">
                        <div class="col-xxl-2 col-xl-2 col-lg-3">
                            <div class="product-all--img">
                                @foreach ($photos as $key => $photo)
                                <a data-zoom-id="productImg"
                                    href="{{ uploadedFile($photo->id) }}"
                                    data-image="{{ uploadedFile($photo->id) }}">
                                    <img src="{{ uploadedFile($photo->id) }}"  alt="{{ isset($galleries_alt[$key]) ? trim($galleries_alt[$key]) : $product->alt }}">
                                </a>
                                @endforeach
                            </div>

                        </div>
                        <div class="col-xx-10 col-xl-10 col-lg-9">
                            <div class="product--thumb">
                                @if($variationImg != null)
                                <a href="{{ uploadedFile($variationImg) }}"
                                    class="MagicZoom" id="productImg"
                                    data-options="zoomWidth:500;zoomHeight:500;zoomPosition:inner;zoomDistance:3;selectorTrigger:hover;lazyZoom:true;rightClick:true;variableZoom:true;"
                                    data-mobile-options="zoomMode:zoom;textClickZoomHint:Double tap to zoom;">

                                    <img class="fit--img" src="{{ uploadedFile($variationImg) }}" alt="{{ $product->alt }}">
                                </a>
                                @else
                                <a href="{{ uploadedFile($product->thumbnail_img) }}"
                                    class="MagicZoom" id="productImg"
                                    data-options="zoomWidth:500;zoomHeight:500;zoomPosition:inner;zoomDistance:3;selectorTrigger:hover;lazyZoom:true;rightClick:true;variableZoom:true;"
                                    data-mobile-options="zoomMode:zoom;textClickZoomHint:Double tap to zoom;">

                                    <img class="fit--img" src="{{ uploadedFile($product->thumbnail_img) }}" alt="{{ $product->alt }}">
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-6 col-xl-5 col-lg-5">
                    <div class="details-wrap">
                        <div class="title--wrap mb-3">
                            <h6 class="title fs--26 fw--500">{{ $product->name }}</h6>
                        </div>

                        <ul class="details--list d-flex flex-column gap--8 mb-3">
                            {!! $product->short_description !!}
                        </ul>

                        <div class="support--number mb-3">
                            <p class="text--base fw--600 fs--20">Call for details : <a href="tel:{{ settings('header_phone') }}"
                                    class="text--base"> {{ settings('header_phone') }}</a></p>
                        </div>

                        <ul class="product--status d-flex flex-wrap justify-content-start align-items-center gap--12">
                            <li class="price">
                                <p class="fs--14">Price: 
                                    @if(($homePrice = $product->regularPrice(false)) != ($discountPrice = $product->discountPrice(false)))
                                    <span class="fw--900">{{ formatPrice($discountPrice) }} {!! $product->unit != null ? '/ <sup><small>PC</small></sup>' : '' !!}</span> 
                                    <span class="del--price text--sm">{{ formatPrice($homePrice) }}</span>
                                    @else
                                    <span class="fw--900">{{ formatPrice($discountPrice) }} {!! $product->unit != null ? '/ <sup><small>PC</small></sup>' : '' !!}</span> 
                                    @endif
                                </p>
                            </li>
                            @php
                                $quantity = $product->variant_product ? $product->stocks->sum('qty') : $product->current_stock;
                            @endphp
                            <li class="price">
                                <p class="fs--14">Status: 
                                    <span class="fw--900">
                                        @if($quantity > 0)
                                        In Stock
                                        @else
                                        <span class="text-danger">
                                        Out Of Stock
                                        </span>
                                        @endif
                                    </span>
                                </p>
                            </li>
                            @if($totalPrice != 0)
                            <li>
                                 @if($quantity > 0)
                                    <button class="btn btn--base pill" type="button" wire:click='addToCart'>Add To Cart</button>
                                @endif
                                </form>
                            </li>
                            <li>
                                <form wire:submit='addToCart(true)'>
                                     @if($quantity > 0)
                                    <button type="submit" class="btn btn-success">Order Now</button>
                                    @endif
                                </form>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

           
           
            <div class="row gy-5">
             <style>
                    h2 {
                        font-size: 25px;
                        font-weight: 200;
                        margin: 0px;
                        color: #04048f;
                        margin-top:10px;
                        margin-bottom:5px;
                    }
                    
                    .table tbody tr td {
                        text-align:left;
                    }
                </style
               

                
                
                <div class="col-lg-12">
                    <div class="ticket--description radius--8 card--bg">
                        <div class="tab-pane fade active show" id="buy" role="tabpanel" aria-labelledby="buy-tab">
                            <ul class="nav nav-tabs custom--tabs  mb-2" role="tablist">

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="Win-tab" data-bs-toggle="tab"
                                        data-bs-target="#Win" type="button" role="tab" aria-selected="false"
                                        tabindex="-1"> Specifications </button>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="specifications-tab" data-bs-toggle="tab"
                                        data-bs-target="#specifications" type="button" role="tab"
                                        aria-selected="true"> Descriptions </button>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="support-tab" data-bs-toggle="tab"
                                        data-bs-target="#support" type="button" role="tab"
                                        aria-selected="true">Support</button>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="galleries-tab" data-bs-toggle="tab"
                                        data-bs-target="#galleries" type="button" role="tab" aria-selected="false"
                                        tabindex="-1">Galleries</button>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane fade active show" id="Win" role="tabpanel"
                                    aria-labelledby="Win-tab">
                                    <div class="row justify-content-start">
                                        <div class="col-lg-8 product-description">
                                            {!! $product->description !!}
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="tab-pane fade" id="specifications" role="tabpanel" aria-labelledby="specifications-tab">
                                    <div class="details-wrap mb-4">
                                        {!! $product->support_description !!}
                                       
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="support" role="tabpanel" aria-labelledby="support-tab">
                                    <div class="details-wrap mb-4">
                                         {!! $product->short_description !!}
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="galleries" role="tabpanel"
                                    aria-labelledby="galleries-tab">
                                    @foreach ($photos as $key => $photo)
                                    <div class="thumb--wrap">
                                        <img src="{{ uploadedFile($photo->id) }}" alt="{{ isset($galleries_alt[$key]) ? trim($galleries_alt[$key]) : $product->alt }}">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
