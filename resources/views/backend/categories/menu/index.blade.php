@extends('backend.layouts.app')

@section('title')
Categories Menu
@endsection
@section('content')
<div class="d-sm-flex justify-content-between">
    <div>
        <a href="{{  route('categories.menus.create')  }}" class="btn btn-icon btn-outline-white">
            Add Menu
        </a>
    </div>
</div>
<div class="card">
    <div class="card-header ">
        <h5 class="mb-md-0 h6">Categories Menu</h5>
    </div>
    <div class="row">
        <div class="col-md-2 ">
            <div class="dropdown pl-2">
                <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Bulk Action
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li>
                        <a class="dropdown-item" href="{{ route('categories.menus.bulk.delete') }}" id="deleteSelected">Delete
                            selection</a>
                    </li>
                </ul>
            </div>
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
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Parent</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">URL</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Target</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Options</th>
                </tr>
            </thead>
            <tbody>

                @forelse ($menus as $menu)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="bulkDelete"
                                    value="{{ $menu->id }}">
                            </div>
                            <p class="text-xs font-weight-bold ms-2 mb-0">{{ $menus->firstItem() + $loop->index }}
                            </p>
                        </div>
                    </td>
                    <td>
                        <h6 class="mb-0 text-xs">{{ $menu->name }}</h6>
                    </td>
                    <td>
                        <h6 class="mb-0 text-xs">{{ $menu->parent?->name }}</h6>
                    </td>
                    <td>
                        <h6 class="mb-0 text-xs">{{ $menu->url }}</h6>
                    </td>
                    <td>
                        <h6 class="mb-0 text-xs">{{ $menu->target }}</h6>
                    </td>
                    <td>
                        <div class="d-flex">
                            <a href="{{ route('categories.menus.edit',$menu->id) }}" class="mr-2">
                                <div class="bg-success badge"><i class="fa fa-pen"></i></div>
                            </a>
                            <a href="{{ route('categories.menus.destroy',$menu->id) }}"
                                onclick="return confirm('Are you sure?')">
                                <div class="bg-danger badge"><i class="fa fa-trash"></i></div>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <td colspan="3">No Data Found!</td>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $menus->links() }}
</div>
@endsection
