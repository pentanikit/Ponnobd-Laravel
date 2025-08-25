@extends('backend.layouts.app')

@section('title')
System Settings
@endsection

@section('content')
x

<div class="container-fluid">
    <div class="card mt-4" id="basic-info">
        <div class="card-header border-bottom">
            <h5>System Settings</h5>
        </div>
        <div class="card-body pt-0">
            <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <label class="form-label">Site Name</label>
                        <input type="hidden" name="types[]" value="site_name">
                        <div class="input-group">
                            <input id="site_name" name="site_name" class="form-control"
                                type="text" placeholder="Site Name" autocomplete="off" value="{{ config('app.name') }}">
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Site Icon</label>
                        <input type="hidden" name="types[]" value="site_icon">
                        <x-upload-file name="site_icon" fileType='image'  value="{{ settings('site_icon') }}"/>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Order Placed Notification Emails <small>( Seprate by comma )</small></label>
                        <input type="hidden" name="types[]" value="order_placed_emails">
                        <div class="input-group">
                            <input id="order_placed_emails" name="order_placed_emails" class="form-control"
                                type="text" placeholder="Emails" autocomplete="off" value="{{ settings('order_placed_emails') }}">
                        </div>
                    </div>
                    <h4 class="p-2">Meta Data</h4>
                    <div class="col-12">
                        <label class="form-label">Meta Title</label>
                        <div class="input-group">
                            <input type="hidden" name="types[]" value="site_meta_title"/>
                            <input id="site_meta_title" name="site_meta_title"
                                class="form-control @error('site_meta_title') is-invalid @enderror" type="text"
                                placeholder="Meta Title" value="{{ settings('site_meta_title') }}" autocomplete="off"/>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Meta Description</label>
                        <input type="hidden" name="types[]" value="site_meta_description">
                        <textarea name="site_meta_description" class="form-control" cols="30" rows="3">{{ settings('site_meta_description') }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Meta Keywords <small>( Separate By Comma)</small></label>
                        <input type="hidden" name="types[]" value="site_meta_keywords">
                        <textarea name="site_meta_keywords" class="form-control" cols="30" rows="2">{{ settings('site_meta_keywords') }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Meta Image</label>
                        <input type="hidden" name="types[]" value="site_meta_image">
                        <x-upload-file name="site_meta_image" fileType='image'  value="{{ settings('site_meta_image') }}"/>
                    </div>
                    <div class="text-center mt-2">
                        <button class="btn btn-success">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
