@extends('backend.layouts.app')

@section('title')
Add Blog Category
@endsection
@section('content')
<div class="container-fluid">
    <div class="card mt-4" id="basic-info">
        <div class="card-header">
            <h5>Add Blog Category</h5>
        </div>
        <div class="card-body pt-0">
            <form action="{{ route('blog.categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <label class="form-label">Category Name</label>
                        <div class="input-group">
                            <input id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                                type="text" placeholder="Category Name" autocomplete="off" value="{{ old('name') }}">
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
                                placeholder="Slug" value="{{ old('slug') }}" autocomplete="off" required>
                        </div>
                        @error('slug')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="text-center mt-2">
                        <button class="btn btn-success">Add Category</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
