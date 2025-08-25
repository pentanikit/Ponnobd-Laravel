@extends('backend.layouts.app')

@section('title')
Edit Blog Category
@endsection
@section('content')
<div class="container-fluid">
    <div class="card mt-4" id="basic-info">
        <div class="card-header">
            <h5>Edit Blog Category</h5>
        </div>
        <div class="card-body pt-0">
            <form action="{{ route('blog.categories.update',$category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <label class="form-label">Category Name</label>
                        <div class="input-group">
                            <input id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                                type="text" placeholder="Category Name" autocomplete="off" value="{{ $category->name }}">
                        </div>
                        @error('name')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-8">
                        <label class="form-label">Slug</label>
                        <div class="input-group">
                            <input id="slug" name="slug"
                                class="form-control @error('slug') is-invalid @enderror" type="text"
                                placeholder="Slug" value="{{ $category->slug }}" autocomplete="off" required>
                        </div>
                        @error('slug')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="text-center mt-2">
                        <button class="btn btn-success">Update Category</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
