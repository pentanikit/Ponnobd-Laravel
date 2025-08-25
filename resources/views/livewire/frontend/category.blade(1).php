@section('meta') 
<meta property="title" content="{{ $category->meta_title ?? $query }}" />
<meta name="keywords" content="{{ $category->meta_keywords }}" />
<meta property="og:title" content="{{ $category->meta_title ?? $query }}" />
<meta property="og:description" content="{{ strip_tags($category->meta_description ?? $category->description) }}" />
<meta name="description" content="{{ strip_tags($category->meta_description ?? $category->description) }}" />
<meta property="og:image:alt" content="{{ $category->meta_title ?? $query }}" />
<meta name="twitter:title" content="{{ $category->meta_title ?? $query }}" />
<meta name="twitter:description" content="{{ strip_tags($category->meta_description ?? $category->description) }}" />
@endsection
@push('js')
<script>
    // rang slider
    const rangeInput = document.querySelectorAll(".range-input input");
    priceInput = document.querySelectorAll(".price-input input");

    progress = document.querySelector(".sliderr .progresss");

    let priceGap = 100;

    rangeInput.forEach(input => {
        input.addEventListener("input", e => {
            calculatePercent();
        })
    });

    calculatePercent();

    function calculatePercent()
    {
        let minValue = parseInt(rangeInput[0].value)
            maxValue = parseInt(rangeInput[1].value)

            if (maxValue - minValue < priceGap) {
                if (e.target.className === "range-min") {
                    rangeInput[0].value = maxValue - priceGap;
                } else {
                    rangeInput[1].value = minValue + priceGap;
                }

            } else {
                priceInput[0].value = minValue;
                priceInput[1].value = maxValue;

                progress.style.left = (minValue / rangeInput[0].max) * 100 + "%";
                progress.style.right = 100 - (maxValue / rangeInput[1].max) * 100 + "%";
            }

            let percent = (minValue / rangeInput[0].max) * 100;
    }

</script>
@endpush
<div>
    <section class="achive--section py-10">
        <div class="container">
            <div class="row gy-4">
                <div class="col-xl-3 d-none d-xl-block">
                    <div class="filter--wrap d-flex flex-column gap--12">
                        <div class="range-slider" data-group-type="status">
                            <div class="label">
                                <span>Price Range</span>
                            </div>
                            <form action="" method="GET">
                                <div class="range-slider-box">
                                    <div class="slider-box mb-4 pb-2">
                                        <div class="sliderr">
                                            <div class="progresss"></div>
                                        </div>
                                        <div class="range-input">
                                            <input type="range" class="range-min" min="0" max="200000" value="{{ request('minPrice',10) }}">
                                            <input type="range" class="range-max" min="0" max="200000" value="{{ request('maxPrice',200000) }}">
                                        </div>
                                    </div>
                                    <div class="price-input d-flex justify-content-between align-items-center gap--24">
                                        <input class="form--control input-min" type="number" value="{{ request('minPrice',10) }}" name="minPrice">
                                        <input class="form--control input-max" type="number" value="{{ request('maxPrice',200000) }}" name="maxPrice">
                                    </div>

                                    <button type="submit" class="btn btn-success text-center mt-2">Filter</button>
                                </div>
                            </form>
                        </div>
    
                        <div class="filter-group show" data-group-type="status">
                            <div class="label">
                                <span>Availability</span>
                            </div>
                            <div class="items">
                                <label class="filter">
                                    <input type="radio" name="status" wire:change='setAvailability("in_stock")' @checked($availability == 'in_stock')>
                                    <span>In Stock</span>
                                </label>
                                <label class="filter">
                                    <input type="radio" name="status" wire:change='setAvailability("out_stock")' @checked($availability == 'out_stock')>
                                    <span>Out Stock</span>
                                </label>
                            </div>
                        </div>
    
                        <div class="filter-group show" data-group-type="status">
                            <div class="label">
                                <span>Brand</span>
                            </div>
                            <div class="items">

                                @foreach ($brands as $item)
                                <label class="filter">
                                    <input type="radio" wire:click='setBrand("{{ $item->id }}")' name="brand_id" value="{{ $item->id }}" @checked($item->id == $brand)>
                                    <span>{{ $item->name }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        @foreach ($attributes as $attribute => $values)
                        <div class="filter-group show" data-group-type="status">
                            <div class="label">
                                <span>{{ App\Models\Attribute::find($attribute)?->name ?? '' }}</span>
                            </div>
                            <div class="items">

                                @foreach ($values as $value)
                                <label class="filter">
                                    <input type="radio" wire:model.live='filters.{{ $attribute }}' value="{{ $value }}">
                                    <span>{{ $value }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-xl-9 col-lg-12">
    
                    <div class="row mb-4">
                        <div class="col-lg-12">
                            <div class="base--card bg--white">
                                <div class="row justify-content-between align-items-center">
                                    <div class="col-lg-3 col-md-4">
                                        <div class="title--wrap d-none d-xl-block">
                                            <h6 class="mb-0">
                                                @if(isset($query))
                                                Searching
                                                @elseif(isset($category))
                                                {{ $category->name }}
                                                @else
                                                Shop
                                                @endif
                                            </h6>
                                        </div>
                                        <div class="filter-btn--wrap d-block d-xl-none">
                                            <button class="btn btn--base filter--btn ">Filter <i class="fa-solid fa-filter"></i></button>
                                        </div>
                                    </div>
                                    <div class="col-lg-7 col-md-8">
                                        <div class="short--filter d-flex flex-wrap gap--16 justify-content-end">
                                            <div class="d-flex align-items-center gap--8 flex-shrink-0">
                                                <p class="flex-shrink-0">Show:</p>
                                                <select class="form-select form--select" wire:change='setLimit($event.target.value)' aria-describedby="show">
                                                    <option value="12" @selected($limit == 12)>12</option>
                                                    <option value="22" @selected($limit == 22)>22</option>
                                                    <option value="33" @selected($limit == 33)>33</option>
                                                </select>
                                            </div>
    
                                            <div class="d-flex align-items-center gap--8 flex-shrink-0">
                                                <p class="flex-shrink-0">Sort by:</p>
                                                <select class="form-select form--select" wire:change='sortBy($event.target.value)' aria-describedby="sortBy">
                                                    <option value="popularity" @selected($sort == 'popularity')> Popularity</option>
                                                    <option value="latest" @selected($sort == 'latest')> Latest</option>
                                                    <option value="oldest" @selected($sort == 'oldest')> Oldest</option>
                                                    <option value="low" @selected($sort == 'low')>Price Low to High </option>
                                                    <option value="high" @selected($sort == 'high')>Price High to Low </option>
                                                </select>
                                            </div>
    
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row gy-4">
                        @forelse ($products as $product)
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-6">
                            <livewire:frontend.product-box :$product wire:key='{{ $product->id }}-{{ mt_rand() }}' lazy="on-load">
                        </div>
                        @empty
                        <div class="text-center p-4 text-danger">
                            <i class="fas fa-warning"></i>
                            No Products Matched!
                        </div>
                        @endforelse
                    </div>
                    {{ $products->onEachSide(0)->links('livewire::bootstrap') }}
                </div>
            </div>
        </div>
    </section>
</div>
