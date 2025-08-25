@extends('backend.layouts.app')

@section('title')
Products
@endsection
@push('js')
<script>
    function updateTodayDeal(el){
        if(el.checked){
            var status = 1;
        }
        else{
            var status = 0;
        }
        $.post('{{ route('products.todays_deal') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
            if(data == 1){
                showAlert('success', '{{ __('Todays Deal updated successfully') }}');
            }
            else{
                showAlert('danger', '{{ __('Something went wrong') }}');
            }
        });
    }

    function updatePublished(el){
        if(el.checked){
            var status = 1;
        }
        else{
            var status = 0;
        }
        $.post('{{ route('products.published') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
            if(data == 1){
                showAlert('success', '{{ __('Published products updated successfully') }}');
            }
            else{
                showAlert('danger', '{{ __('Something went wrong!') }}');
            }
        });
    }

    function updateFeatured(el){
        if(el.checked){
            var status = 1;
        }
        else{
            var status = 0;
        }
        $.post('{{ route('products.featured') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
            if(data == 1){
                showAlert('success', '{{ __('Featured products updated successfully') }}');
            }
            else{
                showAlert('danger', '{{ __('Something went wrong') }}');
            }
        });
    }

</script>
@endpush
@section('content')
@can('products_add')
<div class="d-sm-flex justify-content-between">
    <div>
        <a href="{{  route('products.create')  }}" class="btn btn-icon btn-outline-white">
            Add Product
        </a>
    </div>
</div>
@endcan
<div class="card mb-2">
    <div class="card-body">
        <div class="card-title">Search</div>
        <form>
            <div class="row">
                <div class="col-md-8">
                    <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Search...">
                </div>
                <div class="col-md-4">
                    <button class="btn btn-success">Search</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    @can('products_bulk_delete')
    <div class="col-md-2 ">
        <div class="dropdown p-2">
            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                aria-expanded="false">
                Bulk Action
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li>
                    <a class="dropdown-item" href="{{ route('products.bulk.delete') }}" id="deleteSelected">Delete
                        selection</a>
                </li>
            </ul>
        </div>
    </div>
    @endcan
    <div class="table-responsive">
        <table class="table align-items-center mb-0">
            <thead>
                <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                        <div class="d-flex align-items-center">
                            @can('products_bulk_delete')
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="allSelected">
                            </div>
                            @endcan
                            <p class="text-xs font-weight-bold ms-2 mb-0">#</p>
                        </div>
                    </th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bold ps-2">Categories</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bold ps-2" width="180px">Info</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bold ps-2" width="220px">Total Stock
                    </th>
                    {{-- <th class="text-uppercase text-secondary text-xxs font-weight-bold ps-2">Today Deal</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bold ps-2">Featured</th> --}}
                    @can('products_publish')
                    <th class="text-uppercase text-secondary text-xxs font-weight-bold ps-2">Published</th>
                    @endcan
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Action</th>
                </tr>
            </thead>
            <tbody>

                @forelse ($products as $product)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            @can('products_bulk_delete')
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="bulkDelete" value="{{ $product->id }}">
                            </div>
                            @endcan
                            <p class="text-xs font-weight-bold ms-2 mb-0">{{ $products->firstItem() + $loop->index }}
                            </p>
                        </div>
                    </td>
                    <td>
                        <a href="{{ route('product.details',$product->slug) }}" target="_blank">
                            <img src="{{ uploadedFile($product->thumbnail_img) }}" class="img-fit w-30" loading="lazy">

                            <h6 class="mb-0 text-xs">
                                {{ $product->name }}
                            </h6>
                        </a>
                    </td>
                    <td>
                        <h6 class="mb-0 text-xs">
                            {!! collect($product->categories)->pluck('category.name')->implode(' ,<br>') !!}
                        </h6>
                    </td>
                    <td>
                        <span class="mb-0 text-xs"><b>Brand :</b> {{ $product->brand?->name ?? '--' }}</span> <br>
                        <span class="mb-0 text-xs"><b>Num Of Sale :</b> {{ $product->num_of_sale }}</span> <br>
                        <span class="mb-0 text-xs"><b>Price :</b> {{ price($product->unit_price) }}</span> <br>
                        <span class="mb-0 text-xs"><b>Status :</b>
                            <span @class([ 'badge badge-inline mb-0 text-small' , 'badge-warning'=> $product->status ==
                                'unpublish',
                                'badge-info' => $product->status == 'draft',
                                'badge-success' => $product->status == 'publish',
                                ])>{{ ucfirst($product->status) }}</span>
                        </span>
                        <br>
                        <span class="mb-0 text-xs"><b>Rating :</b> {{ $product->rating }}</span>

                    </td>
                    <td class="text-center">
                        <span class="mb-0 text-xs font-bold">
                            @php
                                $qty = 0;
                                if($product->variant_product) {
                                    foreach ($product->stocks as $key => $stock) {
                                        $qty += $stock->qty;
                                        echo $stock->variant != '' ? "<b>{$stock->variant}</b> - ".$stock->qty.'<br>' : $stock->qty;
                                    }
                                }
                                else {
                                    $qty = $product->current_stock;
                                    echo $qty;
                                }
                            @endphp

                        </span> <br>
                        {!! $qty <= 0 ? '<span class="badge badge-inline badge-danger mb-0 text-small">Low</span>' : ''
                            !!}
                    </td>
                    {{-- <td>
                        <label class="switch">
                            <input type="checkbox" id="deal-{{ $product->id }}" value="{{ $product->id }}"
                                onclick="updateTodayDeal(this)" @checked($product->todays_deal == 1)>
                            <span class="slider round"></span>
                        </label>
                    </td>
                    <td>
                        <label class="switch">
                            <input type="checkbox" id="featured-{{ $product->id }}" value="{{ $product->id }}"
                                onclick="updateFeatured(this)" @checked($product->featured == 1)>
                            <span class="slider round"></span>
                        </label>
                    </td> --}}
                    @can('products_publish')
                    <td>
                        <label class="switch">
                            <input type="checkbox" id="published-{{ $product->id }}" value="{{ $product->id }}"
                                onclick="updatePublished(this)" @checked($product->status == 'publish')>
                            <span class="slider round"></span>
                        </label>
                    </td>
                    @endcan
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-link text-secondary mb-0" data-bs-toggle="dropdown"
                                id="actionLink{{ $product->id }}">
                                <i class="fa fa-ellipsis-v text-xs" aria-hidden="true"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="actionLink{{ $product->id }}">
                                @can('products_edit')
                                <li>
                                    <a class="dropdown-item" href="{{ route('products.edit',$product->id) }}"> <i
                                            class="fa fa-pen"></i> Edit</a>
                                </li>
                                @endcan
                                @can('products_delete')
                                <li>
                                    <a class="dropdown-item" href="{{ route('products.destroy',$product->id) }}"
                                        onclick="return confirm('Are you sure?')"> <i
                                            class="fa fa-trash text-danger"></i> Delete</a>
                                </li>
                                @endcan
                            </ul>
                        </div>
                    </td>
                </tr>
                @empty
                <td colspan="3">No Data Found!</td>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $products->appends(request()->all())->links() }}
</div>
@endsection
