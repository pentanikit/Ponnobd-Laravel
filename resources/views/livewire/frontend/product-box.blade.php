
<div class="product--card radius--8">
    @if($product->discountInPercentage() > 0)
    <div class="tag--wrap">
        <p class="text">Save: {{ $product->discountInPercentage() }}%</p>
    </div>
    @endif

    <a href="{{ route('product.details',['slug' => $product->slug]) }}" class="thumb--wrap d-block"> <img class="fit--img" src="{{ uploadedFile($product->thumbnail_img) }}" alt="{{ $product->name }}"> </a>
    <div class="content--wrap">
        <a href="{{ route('product.details',['slug' => $product->slug]) }}" class="d-block">
            <h1 class="title fs--14 fw--500 mb-2">
                {{ $product->name }}
            </h1>
        </a>
        @php
        $features = json_decode($product->features);
        @endphp
        
        

        
        @if (is_array($features) && array_filter($features))
            <ul>
                @foreach ($features as $feature)
                    <li>{{ $feature }}</li>
                @endforeach
            </ul>
        @endif

    </div> 

    <div class="price--wrap d-flex justify-content-center align-items-center flex-wrap gap--8 mb-3">
        @if(($homePrice = $product->regularPrice(false)) != ($discountPrice = $product->discountPrice(false)))
        <h6 class="price fs--14 fw--700 text--danger mb-0">{{ formatPrice($discountPrice) }}</h6>
        <h6 class="old--price fs--14 fw--700  mb-0">{{ formatPrice($homePrice) }}</h6>
        @else
        <h6 class="price fs--14 fw--700 text--danger mb-0">{{ formatPrice($discountPrice) }}</h6>
        @endif
    </div>

    <div class="btn--wrap"> <a href="{{ route('product.details',['slug' => $product->slug]) }}" class="btn btn--base w--100">Buy Now</a> </div>
</div>
