@extends('backend.layouts.app')

@section('title')
Header Settings
@endsection

@section('content')
x

<div class="container-fluid">
    <div class="card mt-4" id="basic-info">
        <div class="card-header border-bottom">
            <h5>Header Settings</h5>
        </div>
        <div class="card-body pt-0">
            <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <label class="form-label">Phone Number</label>
                        <input type="hidden" name="types[]" value="header_phone">
                        <div class="input-group">
                            <input id="header_phone" name="header_phone" class="form-control"
                                type="text" placeholder="Phone Number" autocomplete="off" value="{{ settings('header_phone') }}">
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Logo</label>
                        <input type="hidden" name="types[]" value="header_logo">
                        <x-upload-file name="header_logo" fileType='image'  value="{{ settings('header_logo') }}"/>
                    </div>
                    {{-- <h4 class="pt-2">Menus</h4>
                    <div class="col-6">
                        <label class="form-label">Name</label>
                        <input type="hidden" name="types[]" value="header_fashion_name">
                        <div class="input-group">
                            <input id="header_fashion_name" name="header_fashion_name" class="form-control"
                                type="text" placeholder="" autocomplete="off" value="{{ settings('header_fashion_name') }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <label class="form-label">URL</label>
                        <input type="hidden" name="types[]" value="header_fashion_url">
                        <div class="input-group">
                            <input id="header_fashion_url" name="header_fashion_url" class="form-control"
                                type="text" placeholder="" autocomplete="off" value="{{ settings('header_fashion_url') }}">
                        </div>
                    </div> --}}
                    <div class="text-center mt-2">
                        <button class="btn btn-success">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
