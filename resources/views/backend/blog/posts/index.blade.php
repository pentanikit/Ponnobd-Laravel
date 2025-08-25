@extends('backend.layouts.app')

@section('title')
Posts
@endsection
@section('content')
<div class="d-sm-flex justify-content-between">
    <div>
        <a href="{{  route('posts.create')  }}" class="btn btn-icon btn-outline-white">
            Add Post
        </a>
    </div>
</div>
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
                    <a class="dropdown-item" href="{{ route('posts.bulk.delete') }}" id="deleteSelected">Delete
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
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Thumbnail</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Title</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($posts as $post)
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="bulkDelete" value="{{ $post->id }}">
                            </div>
                            <p class="text-xs font-weight-bold ms-2 mb-0">
                                {{ $posts->firstItem() + $loop->index }}
                            </p>
                        </div>
                    </td>
                    <td>
                        <h6 class="mb-0 text-xs">
                            <a href="{{ route('product.details',$post->slug) }}" target="_blank">
                                <img src="{{ uploadedFile($post->thumbnail) }}" width="100" class="img-thumbnail img-fluid">
                            </a>
                        </h6>
                    </td>
                    <td>
                        <h6 class="mb-0 text-xs">{{ $post->title }}</h6>
                    </td>

                    <td>
                        <div class="dropdown">
                            <button class="btn btn-link text-secondary mb-0" data-bs-toggle="dropdown"
                                id="actionLink{{ $post->id }}">
                                <i class="fa fa-ellipsis-v text-xs" aria-hidden="true"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="actionLink{{ $post->id }}">
                                <li>
                                    <a class="dropdown-item" href="{{ route('posts.edit',$post->id) }}"> <i
                                            class="fa fa-pen"></i> Edit
                                    </a>
                                </li>

                                <li>
                                    <a class="dropdown-item" href="{{ route('posts.destroy',$post->id) }}"
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
    {{ $posts->appends(request()->all())->links() }}
</div>
@endsection
