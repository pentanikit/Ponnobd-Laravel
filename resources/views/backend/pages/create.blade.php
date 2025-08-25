@extends('backend.layouts.app')

@section('title')
Add Page
@endsection

@section('content')
x

<div class="container-fluid">
    <div class="card mt-4" id="basic-info">
        <div class="card-header">
            <h5>Add Page</h5>
        </div>
        <div class="card-body pt-0">
            <form action="{{ route('pages.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <label class="form-label">Name</label>
                        <div class="input-group">
                            <input id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                                type="text" placeholder="Name" autocomplete="off" value="{{ old('name') }}">
                        </div>
                        @error('name')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Link</label>
                        <div class="input-group d-block d-md-flex">
                            <div class="input-group-prepend "><span class="input-group-text flex-grow-1 bg-gray">{{ url('/') }}/</span></div>
                            <input type="text" class="form-control w-100 w-md-auto @error('slug') border-danger @enderror" placeholder="Slug" name="slug">
                        </div>
                        @error('slug')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="col-12 ">
                        <div class="input-area @error('content') border-danger @enderror">
                            <label class="form-label">Content</label>
                            <x-textarea name='content' placeholder="Write content" value="{{ old('content') }}"/>
                        </div>
                        @error('content')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <h4 class="p-2">Meta Data</h4>
                    <div class="col-12">
                        <label class="form-label">Meta Title</label>
                        <div class="input-group">
                            <input id="meta_title" name="meta_title"
                                class="form-control @error('meta_title') is-invalid @enderror" type="text"
                                placeholder="Meta Title" value="{{ old('meta_title') }}" autocomplete="off">
                        </div>
                        @error('meta_title')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Meta Keywords <small>(Separate By Comma.)</small></label>
                        <textarea name="keywords" class="form-control" cols="30" rows="2" placeholder="Meta keywords">{{ old('keywords') }}</textarea>
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
                        <button class="btn btn-success">Add Page</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
