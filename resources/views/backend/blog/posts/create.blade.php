@extends('backend.layouts.app')

@section('title')
Add Post
@endsection
@push('js')
<script src="{{ asset('backend') }}/assets/js/plugins/choices.min.js"></script>
<script>
    var category = document.getElementById('category_id');
     new Choices(category);
</script>
@endpush
@section('content')
<div class="container-fluid">
    <div class="card mt-4" id="basic-info">
        <div class="card-header">
            <h5>Add Post</h5>
        </div>
        <div class="card-body pt-0">
            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <label class="form-label">Title</label>
                        <div class="input-group">
                            <input id="title" name="title" class="form-control @error('title') is-invalid @enderror"
                                type="text" placeholder="Title" autocomplete="off" value="{{ old('title') }}">
                        </div>
                        @error('title')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="col-6">
                        <label class="form-label">Slug</label>
                        <div class="input-group">
                            <input id="slug" name="slug" class="form-control @error('slug') is-invalid @enderror"
                                type="text" placeholder="Slug" autocomplete="off" value="{{ old('slug') }}">
                        </div>
                        @error('slug')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="col-6 @error('category_id') border-danger @enderror">
                        <div class="input-area">
                            <label class="form-label">Category</label>
                            <select class="form-select" name="category_id" id="category_id" placeholder="Select Category">
                                <option value="" selected>Select Parent Category</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected($category->id == old('category_id'))>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('category_id')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-12 ">
                        <div class="input-area @error('description') border-danger @enderror">
                            <label class="form-label">Description</label>
                            <x-textarea name='description' placeholder="Write description" value="{{ old('description') }}"/>
                        </div>
                        @error('description')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-12 pt-2 ">
                        <label class="form-label">Thumbnail</label>
                        <x-upload-file name="thumbnail" fileType='image' value="{{ old('thumbnail') }}"/>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Thumbnail Alt</label>
                        <div class="input-group">
                            <input id="thumbnail_alt" name="thumbnail_alt" class="form-control @error('thumbnail_alt') is-invalid @enderror"
                                type="text" placeholder="Thumbnail Alt" autocomplete="off" value="{{ old('thumbnail_alt') }}">
                        </div>
                    </div>
                    <h4 class="text-center">Meta Data</h4>
                    <div class="col-12">
                        <label class="form-label">Meta Title</label>
                        <div class="input-group">
                            <input id="meta_title" name="meta_title"
                                class="form-control @error('meta_title') is-invalid @enderror" type="text"
                                placeholder="Meta Title" value="{{ old('meta_title') }}" autocomplete="off" required>
                        </div>
                        @error('meta_title')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Meta Keywords <small>(Separate by comma)</small></label>
                        <div class="input-group">
                            <input id="meta_keywords" name="meta_keywords"
                                class="form-control @error('meta_keywords') is-invalid @enderror" type="text"
                                placeholder="Meta Keywords" value="{{ old('meta_keywords') }}" autocomplete="off" required>
                        </div>
                        @error('meta_keywords')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Meta Description</label>
                        <x-textarea name='meta_description' placeholder='Write meta description' value="{{ old('meta_description') }}"/>
                        @error('meta_description')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="text-center mt-2">
                        <button class="btn btn-success" type="submit">Add Post</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
