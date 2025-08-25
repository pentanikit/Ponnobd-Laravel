@extends('backend.layouts.app')

@section('title')
Footer Settings
@endsection

@section('content')
x

<div class="container-fluid">
    <div class="card mt-4" id="basic-info">
        <div class="card-header border-bottom">
            <h5>Footer Settings</h5>
        </div>
        <div class="card-body pt-0">
            <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <h4 class="pt-3"></h4>
                    <div class="col-12">
                        <label class="form-label">Footer Logo</label>
                        <input type="hidden" name="types[]" value="footer_logo">
                        <x-upload-file name="footer_logo" fileType='image' value="{{ settings('footer_logo') }}"/>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <input type="hidden" name="types[]" value="footer_description">
                        <textarea name="footer_description" class="form-control" cols="30" rows="3" placeholder="Footer Description">{{ settings('footer_description') }}</textarea>
                    </div>
                    <div class="border-bottom p-2"></div>
                    <div class="col-6">
                        <label class="form-label">Facebook Link</label>
                        <input type="hidden" name="types[]" value="fb_link">
                        <div class="input-group">
                            <input id="fb_link" name="fb_link" class="form-control"
                                type="url" placeholder="URL" autocomplete="off" value="{{ settings('fb_link') }}">
                        </div>
                    </div>

                    <div class="col-6">
                        <label class="form-label">YouTube Link</label>
                        <input type="hidden" name="types[]" value="yt_link">
                        <div class="input-group">
                            <input id="yt_link" name="yt_link" class="form-control"
                                type="url" placeholder="URL" autocomplete="off" value="{{ settings('yt_link') }}">
                        </div>
                    </div>

                    <div class="col-6">
                        <label class="form-label">Instagram Link</label>
                        <input type="hidden" name="types[]" value="insta_link">
                        <div class="input-group">
                            <input id="insta_link" name="insta_link" class="form-control"
                                type="url" placeholder="URL" autocomplete="off" value="{{ settings('insta_link') }}">
                        </div>
                    </div>

                    <div class="col-6">
                        <label class="form-label">LinkedIn Link</label>
                        <input type="hidden" name="types[]" value="linkedin_link">
                        <div class="input-group">
                            <input id="linkedin_link" name="linkedin_link" class="form-control"
                                type="url" placeholder="URL" autocomplete="off" value="{{ settings('linkedin_link') }}">
                        </div>
                    </div>

                    <div class="col-6">
                        <label class="form-label">Pinterest Link</label>
                        <input type="hidden" name="types[]" value="pinterest_link">
                        <div class="input-group">
                            <input id="pinterest_link" name="pinterest_link" class="form-control"
                                type="url" placeholder="URL" autocomplete="off" value="{{ settings('pinterest_link') }}">
                        </div>
                    </div>
                    <div class="border-bottom p-2"></div>
                    <div class="col-4">
                        <label class="form-label">Widget One Title</label>
                        <input type="hidden" name="types[]" value="widget_title_one">
                        <div class="input-group">
                            <input id="widget_title_one" name="widget_title_one" class="form-control"
                                type="text" placeholder="Title" autocomplete="off" value="{{ settings('widget_title_one') }}">
                        </div>
                    </div>
                    <div class="col-4">
                        <label class="form-label">Widget Two Title</label>
                        <input type="hidden" name="types[]" value="widget_title_two">
                        <div class="input-group">
                            <input id="widget_title_two" name="widget_title_two" class="form-control"
                                type="text" placeholder="Title" autocomplete="off" value="{{ settings('widget_title_two') }}">
                        </div>
                    </div>
                    <div class="col-4">
                        <label class="form-label">Widget Three Title</label>
                        <input type="hidden" name="types[]" value="widget_title_three">
                        <div class="input-group">
                            <input id="widget_title_three" name="widget_title_three" class="form-control"
                                type="text" placeholder="Title" autocomplete="off" value="{{ settings('widget_title_three') }}">
                        </div>
                    </div>
                    <div class="border-bottom p-2"></div>
                    <h4 class="pt-3">Widget One</h4>
                    <input type="hidden" name="types[]" value="widget_one_title">
                    <input type="hidden" name="types[]" value="widget_one_link">
                    @php
                        $widge_one = is_array(json_decode(settings('widget_one_title'))) ? json_decode(settings('widget_one_title')) : [];
                        $widge_one_links = @json_decode(settings('widget_one_link'));
                    @endphp
                    <div class="add-widget-one">
                        @foreach ($widge_one as $key => $title)
                        <div class="row">
                            <div class="col-4">
                                <label class="form-label"> Title</label>
                                <div class="input-group">
                                    <input id="widget_one_title" name="widget_one_title[]" class="form-control"
                                        type="text" placeholder="Title" value="{{ $title }}" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-4">
                                <label class="form-label"> URL</label>
                                <div class="input-group">
                                    <input id="widget_one_link" name="widget_one_link[]" class="form-control"
                                        type="url" placeholder="URL" autocomplete="off" value="{{ $widge_one_links[$key] }}">
                                </div>
                            </div>
                            <div class="col-2">
                                <label class="form-label">Remove</label> <br>
                                <button type="button" data-toggle="remove-parent" data-parent=".row" class="btn btn-danger"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        @endforeach

                    </div>
                    <div class="input-group">
                        <button type="button" data-toggle="add-more" data-content='
                        <div class="row">
                            <div class="col-5">
                                <label class="form-label"> Title</label>
                                <div class="input-group">
                                    <input id="widget_one_title" name="widget_one_title[]" class="form-control"
                                        type="text" placeholder="Title" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-5">
                                <label class="form-label"> URL</label>
                                <div class="input-group">
                                    <input id="widget_one_link" name="widget_one_link[]" class="form-control"
                                        type="url" placeholder="URL" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-2">
                                <label class="form-label">Remove</label> <br>
                                <button type="button" data-toggle="remove-parent" data-parent=".row" class="btn btn-danger"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        ' class="btn btn-success" data-target=".add-widget-one"><i class="fa fa-plus"></i> Add More</button>
                    </div>
                    <div class="border-bottom p-2"></div>
                    <h4 class="pt-3">Widget Two</h4>
                    <input type="hidden" name="types[]" value="widget_two_title">
                    <input type="hidden" name="types[]" value="widget_two_link">
                    @php
                        $widge_two = is_array(json_decode(settings('widget_two_title'))) ? json_decode(settings('widget_two_title')) : [];
                        $widge_two_links = @json_decode(settings('widget_two_link'));
                    @endphp
                    <div class="add-widget-two">
                        @foreach ($widge_two as $key => $title)
                        <div class="row">
                            <div class="col-4">
                                <label class="form-label"> Title</label>
                                <div class="input-group">
                                    <input id="widget_two_title" name="widget_two_title[]" class="form-control"
                                        type="text" placeholder="Title" value="{{ $title }}" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-4">
                                <label class="form-label"> URL</label>
                                <div class="input-group">
                                    <input id="widget_two_link" name="widget_two_link[]" class="form-control"
                                        type="url" placeholder="URL" autocomplete="off" value="{{ $widge_two_links[$key] }}">
                                </div>
                            </div>
                            <div class="col-2">
                                <label class="form-label">Remove</label> <br>
                                <button type="button" data-toggle="remove-parent" data-parent=".row" class="btn btn-danger"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        @endforeach

                    </div>
                    <div class="input-group">
                        <button type="button" data-toggle="add-more" data-content='
                        <div class="row">
                            <div class="col-5">
                                <label class="form-label"> Title</label>
                                <div class="input-group">
                                    <input id="widget_two_title" name="widget_two_title[]" class="form-control"
                                        type="text" placeholder="Title" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-5">
                                <label class="form-label"> URL</label>
                                <div class="input-group">
                                    <input id="widget_two_link" name="widget_two_link[]" class="form-control"
                                        type="url" placeholder="URL" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-2">
                                <label class="form-label">Remove</label> <br>
                                <button type="button" data-toggle="remove-parent" data-parent=".row" class="btn btn-danger"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        ' class="btn btn-success" data-target=".add-widget-two"><i class="fa fa-plus"></i> Add More</button>
                    </div>
                    <div class="border-bottom p-2"></div>
                    <h4 class="pt-3">Widget Three</h4>
                    <input type="hidden" name="types[]" value="widget_three_title">
                    <input type="hidden" name="types[]" value="widget_three_link">
                    @php
                        $widge_three = is_array(json_decode(settings('widget_three_title'))) ? json_decode(settings('widget_three_title')) : [];
                        $widge_three_links = @json_decode(settings('widget_three_link'));
                    @endphp
                    <div class="add-widget-three">
                        @foreach ($widge_three as $key => $title)
                        <div class="row">
                            <div class="col-4">
                                <label class="form-label"> Title</label>
                                <div class="input-group">
                                    <input id="widget_three_title" name="widget_three_title[]" class="form-control"
                                        type="text" placeholder="Title" value="{{ $title }}" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-4">
                                <label class="form-label"> URL</label>
                                <div class="input-group">
                                    <input id="widget_three_link" name="widget_three_link[]" class="form-control"
                                        type="url" placeholder="URL" autocomplete="off" value="{{ @$widge_three_links[$key] }}">
                                </div>
                            </div>
                            <div class="col-2">
                                <label class="form-label">Remove</label> <br>
                                <button type="button" data-toggle="remove-parent" data-parent=".row" class="btn btn-danger"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        @endforeach

                    </div>
                    <div class="input-group">
                        <button type="button" data-toggle="add-more" data-content='
                        <div class="row">
                            <div class="col-5">
                                <label class="form-label"> Title</label>
                                <div class="input-group">
                                    <input id="widget_three_title" name="widget_three_title[]" class="form-control"
                                        type="text" placeholder="Title" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-5">
                                <label class="form-label"> URL</label>
                                <div class="input-group">
                                    <input id="widget_three_link" name="widget_three_link[]" class="form-control"
                                        type="url" placeholder="URL" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-2">
                                <label class="form-label">Remove</label> <br>
                                <button type="button" data-toggle="remove-parent" data-parent=".row" class="btn btn-danger"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        ' class="btn btn-success" data-target=".add-widget-three"><i class="fa fa-plus"></i> Add More</button>
                    </div>
                    <div class="border-bottom p-2"></div>
                    <h4 class="pt-3">Showroom Address</h4>
                    <input type="hidden" name="types[]" value="footer_showroom_phone_one">
                    <input type="hidden" name="types[]" value="footer_showroom_phone_two">
                    <input type="hidden" name="types[]" value="footer_showroom_title">
                    <input type="hidden" name="types[]" value="footer_showroom_description">
                    @php
                        $footer_showrooms = is_array(json_decode(settings('footer_showroom_title'))) ? json_decode(settings('footer_showroom_title')) : [];
                        $descriptions = @json_decode(settings('footer_showroom_description'));
                        $one_phones = @json_decode(settings('footer_showroom_phone_one'));
                        $two_phones = @json_decode(settings('footer_showroom_phone_two'));
                    @endphp
                    <div class="add-showroom">
                        @foreach ($footer_showrooms as $key => $title)
                        <div class="row">
                            <div class="col-2">
                                <label class="form-label"> Title</label>
                                <div class="input-group">
                                    <input id="footer_showroom_title" name="footer_showroom_title[]" class="form-control"
                                        type="text" placeholder="Title" autocomplete="off" value="{{ @$title }}">
                                </div>
                            </div>
                            <div class="col-4">
                                <label class="form-label"> Details</label>
                                <div class="input-group">
                                    <input id="footer_showroom_description" name="footer_showroom_description[]" class="form-control"
                                        type="text" placeholder="Description" autocomplete="off" value="{{ @$descriptions[$key] }}">
                                </div>
                            </div>
                            <div class="col-2">
                                <label class="form-label"> Phone 1</label>
                                <div class="input-group">
                                    <input id="footer_showroom_phone_one" name="footer_showroom_phone_one[]" class="form-control"
                                        type="text" placeholder="Phone 1" autocomplete="off" value="{{ @$one_phones[$key] }}">
                                </div>
                            </div>
                            <div class="col-2">
                                <label class="form-label"> Phone 2</label>
                                <div class="input-group">
                                    <input id="footer_showroom_phone_two" name="footer_showroom_phone_two[]" class="form-control"
                                        type="text" placeholder="Phone 2" autocomplete="off" value="{{ @$two_phones[$key] }}">
                                </div>
                            </div>
                            <div class="col-2">
                                <label class="form-label">Remove</label> <br>
                                <button type="button" data-toggle="remove-parent" data-parent=".row" class="btn btn-danger"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        @endforeach

                    </div>
                    <div class="input-group">
                        <button type="button" data-toggle="add-more" data-content='
                        <div class="row">
                            <div class="col-2">
                                <label class="form-label"> Title</label>
                                <div class="input-group">
                                    <input id="footer_showroom_title" name="footer_showroom_title[]" class="form-control"
                                        type="text" placeholder="Title" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-4">
                                <label class="form-label"> Details</label>
                                <div class="input-group">
                                    <input id="footer_showroom_description" name="footer_showroom_description[]" class="form-control"
                                        type="text" placeholder="Description" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-2">
                                <label class="form-label"> Phone 1</label>
                                <div class="input-group">
                                    <input id="footer_showroom_phone_one" name="footer_showroom_phone_one[]" class="form-control"
                                        type="text" placeholder="Phone 1" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-2">
                                <label class="form-label"> Phone 2</label>
                                <div class="input-group">
                                    <input id="footer_showroom_phone_two" name="footer_showroom_phone_two[]" class="form-control"
                                        type="text" placeholder="Phone 2" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-2">
                                <label class="form-label">Remove</label> <br>
                                <button type="button" data-toggle="remove-parent" data-parent=".row" class="btn btn-danger"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        ' class="btn btn-success" data-target=".add-showroom"><i class="fa fa-plus"></i> Add More</button>
                    </div>
                    <div class="border-bottom p-2"></div>
                    <div class="col-12">
                        <label class="form-label">Copyright Text</label>
                        <input type="hidden" name="types[]" value="copyright_text">
                        <x-textarea name='copyright_text' placeholder='Copyright Text' value="{{ settings('copyright_text') }}"/>
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
