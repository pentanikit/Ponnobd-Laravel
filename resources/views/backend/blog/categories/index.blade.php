@extends('backend.layouts.app')

@section('title')
Categories
@endsection
@section('content')
@can('categories_add')
<div class="d-sm-flex justify-content-between">
    <div>
        <a href="{{  route('blog.categories.create')  }}" class="btn btn-icon btn-outline-white">
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
    <div class="col-md-2 ">
        <div class="dropdown p-2">
            <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                aria-expanded="false">
                Bulk Action
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li>
                    <a class="dropdown-item" href="{{ route('blog.categories.bulk.delete') }}" id="deleteSelected">Delete
                        selection</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table align-items-center mb-0">
            <thead>
                <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">

                        <div class="d-flex align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="allSelected">
                            </div>
                            <p class="text-xs font-weight-bold ms-2 mb-0">#</p>
                        </div>
                    </th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Slug</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="bulkDelete" value="{{ $category->id }}">
                            </div>
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
                        <h6 class="mb-0 text-xs">{{ $category->slug }}</h6>
                    </td>

                    <td>
                        <div class="dropdown">
                            <button class="btn btn-link text-secondary mb-0" data-bs-toggle="dropdown"
                                id="actionLink{{ $category->id }}">
                                <i class="fa fa-ellipsis-v text-xs" aria-hidden="true"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="actionLink{{ $category->id }}">
                                <li>
                                    <a class="dropdown-item" href="{{ route('blog.categories.edit',$category->id) }}"> <i
                                            class="fa fa-pen"></i> Edit
                                    </a>
                                </li>

                                <li>
                                    <a class="dropdown-item" href="{{ route('blog.categories.destroy',$category->id) }}"
                                        onclick="return confirm('Are you sure?')">
                                        <i class="fa fa-trash text-danger"></i> Delete
                                    </a>
                                </li>
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
