@extends('backend.layouts.app')

@section('title')
Categories
@endsection
@push('js')
<script>
    function updateFeatured(el){
        if(el.checked){
            var status = 1;
        }
        else{
            var status = 0;
        }
        $.post('{{ route('categories.featured') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
            if(data == 1){
                showAlert('success', '{{ __('Category featured  updated successfully!') }}');
            }
            else{
                showAlert('danger', '{{ __('Something went wrong') }}');
            }
        });
    }
</script>
@endpush
@section('content')
@can('categories_add')
<div class="d-sm-flex justify-content-between">
    <div>
        <a href="{{  route('categories.create')  }}" class="btn btn-icon btn-outline-white">
            Add Category
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
    @can('categories_bulk_delete')
    <div class="col-md-2 ">
        <div class="dropdown p-2">
            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                aria-expanded="false">
                Bulk Action
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li>
                    <a class="dropdown-item" href="{{ route('categories.bulk.delete') }}" id="deleteSelected">Delete
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
                            @can('categories_bulk_delete')
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="allSelected">
                            </div>
                            @endcan
                            <p class="text-xs font-weight-bold ms-2 mb-0">#</p>
                        </div>
                    </th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Parent</th>
                    {{-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Featured</th> --}}
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Product Count
                    </th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Action</th>
                </tr>
            </thead>
            <tbody>

                @forelse ($categories as $category)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            @can('categories_bulk_delete')
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="bulkDelete" value="{{ $category->id }}">
                            </div>
                            @endcan
                            <p class="text-xs font-weight-bold ms-2 mb-0">{{ $categories->firstItem() + $loop->index }}
                            </p>
                        </div>
                    </td>
                    <td>
                        <h6 class="mb-0 text-xs">
                            <a href="{{ route('product.details',$category->slug) }}" target="_blank">{{ $category->name }}</a>
                        </h6>
                    </td>
                    <td>
                        <h6 class="mb-0 text-xs">{{ $category->parentCategory?->name ?? '--' }}</h6>
                    </td>
                    {{-- <td>
                        <label class="switch">
                            <input type="checkbox" id="featured-{{ $category->id }}" value="{{ $category->id }}"
                                onclick="updateFeatured(this)" @checked($category->featured == 1)>
                            <span class="slider round"></span>
                        </label>
                    </td> --}}
                    <td>
                        <h6 class="mb-0 text-xs">{{ $category->products_count }}</h6>
                    </td>
                    <td>

                        <div class="dropdown">
                            <button class="btn btn-link text-secondary mb-0" data-bs-toggle="dropdown"
                                id="actionLink{{ $category->id }}">
                                <i class="fa fa-ellipsis-v text-xs" aria-hidden="true"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="actionLink{{ $category->id }}">
                                @can('categories_edit')
                                <li>
                                    <a class="dropdown-item" href="{{ route('categories.edit',$category->id) }}"> <i
                                            class="fa fa-pen"></i> Edit
                                    </a>
                                </li>
                                @endcan
                                @can('categories_delete')
                                <li>
                                    <a class="dropdown-item" href="{{ route('categories.destroy',$category->id) }}"
                                        onclick="return confirm('Are you sure?')"> <i
                                            class="fa fa-trash text-danger"></i> Delete</a>
                                </li>
                                @endcan
                            </ul>
                        </div>
                    </td>
                </tr>
                @empty
                <td colspan="6">No Data Found!</td>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $categories->appends(request()->all())->links() }}
</div>
@endsection
