@extends('backend.layouts.app')

@section('title')
Home Settings
@endsection

@section('content')
x

<div class="container-fluid">
    <div class="card mt-4" id="basic-info">
        <div class="card-header border-bottom">
            <h5>Home Settings</h5>
        </div>
        <div class="card-body pt-0">
            <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <h5 class="pt-3">Home Galleries</h5>
                    <input type="hidden" name="types[]" value="home_galleries_image">
                    <input type="hidden" name="types[]" value="home_galleries_link">
                    @php
                        $galleries = is_array(json_decode(settings('home_galleries_image'))) ? json_decode(settings('home_galleries_image')) : [];
                        $links = @json_decode(settings('home_galleries_link'));
                        $pixels = [
                            0 => '625x447',
                            1 => '630x271',
                            2 => '310x168',
                            3 => '310x168'
                        ];
                    @endphp
                    <div class="add-gallery">
                        @foreach ($galleries as $key => $gallery)
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Image <small class="text-danger">(Size: {{ $pixels[$key] }})</small></label>
                                <x-upload-file name="home_galleries_image[]" fileType='image' value="{{ @$gallery }}"/>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Url</label>
                                <div class="input-group">
                                    <input id="home_galleries_link" name="home_galleries_link[]" class="form-control"
                                        type="text" placeholder="Url" autocomplete="off" value="{{ @$links[$key] }}">
                                </div>
                            </div>
                            {{-- <div class="col-1">
                                <label class="form-label">Remove</label> <br>
                                <button type="button" data-toggle="remove-parent" data-parent=".row" class="btn btn-danger"><i class="fa fa-times"></i></button>
                            </div> --}}
                        </div>
                        @endforeach

                    </div>
                    {{-- <div class="input-group">
                        <button type="button" data-toggle="add-more" data-content='
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Image</label>
                                <x-upload-file name="home_galleries_image[]" fileType='image'/>
                            </div>
                            <div class="col-5">
                                <label class="form-label">Url</label>
                                <div class="input-group">
                                    <input id="home_galleries_link" name="home_galleries_link[]" class="form-control"
                                        type="text" placeholder="Url" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-1">
                                <label class="form-label">Remove</label> <br>
                                <button type="button" data-toggle="remove-parent" data-parent=".row" class="btn btn-danger"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        ' class="btn btn-success" data-target=".add-gallery"><i class="fa fa-plus"></i> Add More</button>
                    </div> --}}
                    <h4 class="pt-3">Product Category Section</h4>
                    <div class="col-6">
                        <label class="form-label">Title</label>
                        <div class="input-group">
                            <input type="hidden" name="types[]" value="pro_cat_title">
                            <input id="pro_cat_title" name="pro_cat_title" class="form-control"
                                type="text" placeholder="Title" autocomplete="off" value="{{ settings('pro_cat_title') }}">
                        </div>
                    </div>
                    <input type="hidden" name="types[]" value="cat_icon">
                    <input type="hidden" name="types[]" value="cat_title">
                    <input type="hidden" name="types[]" value="cat_link">
                    @php
                        $categories = is_array(json_decode(settings('cat_title'))) ? json_decode(settings('cat_title')) : [];
                        $links = @json_decode(settings('cat_link'));
                        $icons = @json_decode(settings('cat_icon'));
                    @endphp
                    <div class="add-service">
                        @foreach ($categories as $key => $title)
                        <div class="row">
                            <div class="col-3">
                                <label class="form-label">Icon</label>
                                <x-upload-file name="cat_icon[]" fileType='image' value="{{ @$icons[$key] }}"/>
                            </div>
                            <div class="col-3">
                                <label class="form-label">Title</label>
                                <div class="input-group">
                                    <input id="cat_title" name="cat_title[]" class="form-control"
                                        type="text" placeholder="Title" autocomplete="off" value="{{ @$title }}">
                                </div>
                            </div>
                            <div class="col-5">
                                <label class="form-label">Url</label>
                                <div class="input-group">
                                    <input id="cat_link" name="cat_link[]" class="form-control"
                                        type="text" placeholder="Url" autocomplete="off" value="{{ @$links[$key] }}">
                                </div>
                            </div>
                            <div class="col-1">
                                <label class="form-label">Remove</label> <br>
                                <button type="button" data-toggle="remove-parent" data-parent=".row" class="btn btn-danger"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        @endforeach

                    </div>
                    <div class="input-group">
                        <button type="button" data-toggle="add-more" data-content='
                        <div class="row">
                            <div class="col-3">
                                <label class="form-label">Icon</label>
                                <x-upload-file name="cat_icon[]" fileType='image'/>
                            </div>
                            <div class="col-3">
                                <label class="form-label">Title</label>
                                <div class="input-group">
                                    <input id="cat_title" name="cat_title[]" class="form-control"
                                        type="text" placeholder="Title" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-5">
                                <label class="form-label">URL</label>
                                <div class="input-group">
                                    <input id="cat_link" name="cat_link[]" class="form-control"
                                        type="text" placeholder="URL" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-1">
                                <label class="form-label">Remove</label> <br>
                                <button type="button" data-toggle="remove-parent" data-parent=".row" class="btn btn-danger"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        ' class="btn btn-success" data-target=".add-service"><i class="fa fa-plus"></i> Add More</button>
                    </div>
                    <h4 class="pt-3">Footer Content</h4>
                    <div class="col-12">
                        <label class="form-label">Content</label>
                        <input type="hidden" name="types[]" value="footer_content">
                        <x-textarea name='footer_content' placeholder='Write content' value="{{ settings('footer_content') }}"/>
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
