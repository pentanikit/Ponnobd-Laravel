@extends('backend.layouts.app')

@section('title')
Brands
@endsection
@section('content')
@can('brands_add')
<div class="d-sm-flex justify-content-between">
    <div>
        <a href="{{  route('brand.create')  }}" class="btn btn-icon btn-outline-white">
            Add Brand
        </a>
    </div>
</div>
@endcan
<div class="card">
    @can('brands_bulk_delete')
    <div class="col-md-2 ">
        <div class="dropdown p-2">
            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                aria-expanded="false">
                Bulk Action
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li>
                    <a class="dropdown-item" href="{{ route('brand.bulk.delete') }}" id="deleteSelected">Delete
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
                            @can('brands_bulk_delete')
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="allSelected">
                            </div>
                            @endcan
                            <p class="text-xs font-weight-bold ms-2 mb-0">#</p>
                        </div>
                    </th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Product count
                    </th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Action</th>
                </tr>
            </thead>
            <tbody>

                @forelse ($brands as $brand)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            @can('brands_bulk_delete')
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="bulkDelete" value="{{ $brand->id }}">
                            </div>
                            @endcan

                            <p class="text-xs font-weight-bold ms-2 mb-0">{{ $brands->firstItem() + $loop->index }}</p>
                        </div>
                    </td>
                    <td>
                        <h6 class="mb-0 text-xs">{{ $brand->name }}</h6>
                    </td>
                    <td>
                        {{ $brand->products_count }}
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-link text-secondary mb-0" data-bs-toggle="dropdown"
                                id="actionLink{{ $brand->id }}">
                                <i class="fa fa-ellipsis-v text-xs" aria-hidden="true"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="actionLink{{ $brand->id }}">
                                @can('brands_edit')
                                <li>
                                    <a class="dropdown-item" href="{{ route('brand.edit',$brand->id) }}"> <i
                                            class="fa fa-pen"></i> Edit</a>
                                </li>
                                @endif
                                @can('brands_delete')
                                <li>
                                    <a class="dropdown-item" href="{{ route('brand.destroy',$brand->id) }}"
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
    {{ $brands->links() }}
</div>
@endsection
