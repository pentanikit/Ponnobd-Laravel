@extends('backend.layouts.app')

@section('title')
Edit Brand
@endsection

@section('content')
<div class="container-fluid">
    <div class="card mt-4" id="basic-info">
        <div class="card-header">
            <h5>Edit Brand</h5>
        </div>
        <div class="card-body pt-0">
            <form action="{{ route('brand.update',$brand->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <label class="form-label">Name</label>
                        <div class="input-group">
                            <input id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                                type="text" placeholder="Name" autocomplete="off" value="{{ $brand->name }}">
                        </div>
                        @error('name')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="col-12 ">
                        <div class="input-area @error('description') border-danger @enderror">
                            <label class="form-label">Description</label>
                            <x-textarea name='description' placeholder="Write description" value="{{ $brand->description }}"/>
                        </div>
                        @error('description')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-12 pt-2 ">
                        <label class="form-label">Logo</label>
                        <x-upload-file name="logo" fileType='image' value="{{ $brand->logo }}"/>
                    </div>
                    <h4 class="text-center">Meta Data</h4>
                    <div class="col-12">
                        <label class="form-label">Meta Title</label>
                        <div class="input-group">
                            <input id="meta_title" name="meta_title"
                                class="form-control @error('meta_title') is-invalid @enderror" type="text"
                                placeholder="Meta Title" value="{{ $brand->meta_title }}" autocomplete="off">
                        </div>
                        @error('meta_title')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Meta Description</label>
                        <x-textarea name='meta_description' placeholder='Write meta description' value="{{ $brand->meta_description }}"/>
                        @error('meta_description')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="text-center mt-2">
                        <button class="btn btn-success">Update Brand</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
