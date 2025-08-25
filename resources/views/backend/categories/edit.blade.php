@extends('backend.layouts.app')

@section('title')
Edit Category
@endsection
@push('js')
<script src="{{ asset('backend') }}/assets/js/plugins/choices.min.js"></script>
<script>
    var parentCategory = document.getElementById('parentCategory');
    new Choices(parentCategory);
</script>
@endpush
@section('content')
<div class="container-fluid">
    <div class="card mt-4" id="basic-info">
        <div class="card-header">
            <h5>Edit Category</h5>
        </div>
        <div class="card-body pt-0">
            <form action="{{ route('categories.update',$category->id) }}" method="POST" novalidate enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-6">
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

                    <div class="col-6 @error('parent_category_id') border-danger @enderror">
                        <div class="input-area">
                            <label class="form-label">Parent Category</label>
                            <select class="form-select" name="parent_category_id" id="parentCategory"
                                placeholder="Select Category">
                                <option value="" selected>Select Parent Category</option>
                                @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" @selected($cat->id == $category->parent_id)>{{ $cat->name }}
                                    - {{ $cat->products_count }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('parent_category_id')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Slug</label>
                        <div class="input-group">
                            <input id="slug" name="slug" class="form-control @error('slug') is-invalid @enderror"
                                type="text" placeholder="Category slug" autocomplete="off" value="{{ old('slug',$category->slug) }}">
                        </div>
                        @error('slug')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-12 ">
                        <div class="input-area @error('description') border-danger @enderror">
                            <label class="form-label">Description</label>
                            <x-textarea name='description' placeholder="Write description" value="{{ $category->description }}"/>
                        </div>
                        @error('description')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-12 pt-2 ">
                        <label class="form-label">Icon</label>
                        <x-upload-file name="icon" fileType='image' value="{{ $category->icon }}"/>
                    </div>
                    <h4 class="text-center">Meta Data</h4>
                    <div class="col-12">
                        <label class="form-label">Meta Title</label>
                        <div class="input-group">
                            <input id="meta_title" name="meta_title"
                                class="form-control @error('meta_title') is-invalid @enderror" type="text"
                                placeholder="Meta Title" autocomplete="off" value="{{ $category->meta_title }}" required>
                        </div>
                        @error('meta_title')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Meta Keywords</label>
                        <div class="input-group">
                            <input id="meta_keywords" name="meta_keywords"
                                class="form-control @error('meta_keywords') is-invalid @enderror" type="text"
                                placeholder="Meta Keywords" autocomplete="off" value="{{ $category->meta_keywords }}" required />
                        </div>
                        @error('meta_keywords')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Meta Description</label>
                        <x-textarea name='meta_description' placeholder='Write meta description' value="{{ $category->meta_description }}" required />
                        @error('meta_description')
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
