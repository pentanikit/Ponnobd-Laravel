@extends('backend.layouts.app')

@section('title')
Contact Us Settings
@endsection

@section('content')
x

<div class="container-fluid">
    <div class="card mt-4" id="basic-info">
        <div class="card-header border-bottom">
            <h5>Contact Us Settings</h5>
        </div>
        <div class="card-body pt-0">
            <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <h4 class="pt-3">Showroom Address</h4>
                    <input type="hidden" name="types[]" value="location_phone">
                    <input type="hidden" name="types[]" value="location_title">
                    <input type="hidden" name="types[]" value="location_description">
                    @php
                        $locations = is_array(json_decode(settings('location_title'))) ? json_decode(settings('location_title')) : [];
                        $descriptions = @json_decode(settings('location_description'));
                        $phones = @json_decode(settings('location_phone'));
                    @endphp
                    <div class="add-showroom">
                        @foreach ($locations as $key => $title)
                        <div class="row">
                            <div class="col-3">
                                <label class="form-label">Location Title</label>
                                <div class="input-group">
                                    <input id="location_title" name="location_title[]" class="form-control"
                                        type="text" placeholder="Title" autocomplete="off" value="{{ @$title }}">
                                </div>
                            </div>
                            <div class="col-4">
                                <label class="form-label">Location Details</label>
                                <div class="input-group">
                                    <input id="location_description" name="location_description[]" class="form-control"
                                        type="text" placeholder="Description" autocomplete="off" value="{{ @$descriptions[$key] }}">
                                </div>
                            </div>
                            <div class="col-3">
                                <label class="form-label">Location Phone</label>
                                <div class="input-group">
                                    <input id="location_phone" name="location_phone[]" class="form-control"
                                        type="text" placeholder="Phone" autocomplete="off" value="{{ @$phones[$key] }}">
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
                            <div class="col-3">
                                <label class="form-label">Location Title</label>
                                <div class="input-group">
                                    <input id="location_title" name="location_title[]" class="form-control"
                                        type="text" placeholder="Title" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-4">
                                <label class="form-label">Location Details</label>
                                <div class="input-group">
                                    <input id="location_description" name="location_description[]" class="form-control"
                                        type="text" placeholder="Description" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-3">
                                <label class="form-label">Location Phone</label>
                                <div class="input-group">
                                    <input id="location_phone" name="location_phone[]" class="form-control"
                                        type="text" placeholder="Phone" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-2">
                                <label class="form-label">Remove</label> <br>
                                <button type="button" data-toggle="remove-parent" data-parent=".row" class="btn btn-danger"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        ' class="btn btn-success" data-target=".add-showroom"><i class="fa fa-plus"></i> Add More</button>
                    </div>
                    <h4 class="pt-3">Contact Form</h4>
                    <div class="col-12">
                        <label class="form-label">Title</label>
                        <input type="hidden" name="types[]" value="contact_title">
                        <div class="input-group">
                            <input id="contact_title" name="contact_title" class="form-control"
                                type="text" placeholder="Title" autocomplete="off" value="{{ settings('contact_title') }}">
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <input type="hidden" name="types[]" value="contact_description">
                        <div class="input-group">
                            <input id="contact_description" name="contact_description" class="form-control"
                                type="text" placeholder="Description" autocomplete="off" value="{{ settings('contact_description') }}">
                        </div>
                    </div>
                    <h4 class="pt-3">Head Office Address</h4>
                    <div class="col-12">
                        <label class="form-label">Title</label>
                        <input type="hidden" name="types[]" value="headoffice_title">
                        <div class="input-group">
                            <input id="headoffice_title" name="headoffice_title" class="form-control"
                                type="text" placeholder="Title" autocomplete="off" value="{{ settings('headoffice_title') }}">
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Address</label>
                        <input type="hidden" name="types[]" value="headoffice_address">
                        <div class="input-group">
                            <input id="headoffice_address" name="headoffice_address" class="form-control"
                                type="text" placeholder="Address" autocomplete="off" value="{{ settings('headoffice_address') }}">
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Email Address</label>
                        <input type="hidden" name="types[]" value="headoffice_email">
                        <div class="input-group">
                            <input id="headoffice_email" name="headoffice_email" class="form-control"
                                type="email" placeholder="Email Address" autocomplete="off" value="{{ settings('headoffice_email') }}">
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Phone Number</label>
                        <input type="hidden" name="types[]" value="headoffice_phone">
                        <div class="input-group">
                            <input id="headoffice_phone" name="headoffice_phone" class="form-control"
                                type="text" placeholder="Phone Number" autocomplete="off" value="{{ settings('headoffice_phone') }}">
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Map Code</label>
                        <input type="hidden" name="types[]" value="contact_map_code">
                        <textarea name="contact_map_code" class="form-control" cols="30" rows="2">{{ settings('contact_map_code') }}</textarea>
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
