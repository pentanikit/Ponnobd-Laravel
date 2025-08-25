@extends('backend.layouts.app')

@section('title')
About Us Settings
@endsection
@push('js')
<script>

    $(document).ready(function(){
        $('.service_description').summernote({
            height: 150,
            toolbar: [
                ["font", ["bold", "underline", "italic", "clear"]],
                ["para", ["ul", "ol", "paragraph"]],
                ["style", ["style"]],
                ["color", ["color"]],
                ["view", ["undo", "redo"]],
            ],
            disableDragAndDrop: true,
            shortcuts: false,
            placeholder: "Service Description",
        });
    });

</script>
@endpush
@section('content')
<div class="container-fluid">
    <div class="card mt-4" id="basic-info">
        <div class="card-header">
            <h5>About Us Settings</h5>
        </div>
        <div class="card-body pt-0">
            <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    {{-- <div class="col-12">
                        <label class="form-label">Thumbnail</label>
                        <input type="hidden" name="types[]" value="about_thumbnail">
                        <x-upload-file name="about_thumbnail" fileType='image'  value="{{ settings('about_thumbnail') }}"/>
                    </div> --}}
                    <h4 class="pt-3">Speech from CEO</h4>
                    <div class="col-12">
                        <label class="form-label">Title</label>
                        <input type="hidden" name="types[]" value="ceo_speech_title">
                        <div class="input-group">
                            <input id="ceo_speech_title" name="ceo_speech_title" class="form-control @error('ceo_speech_title') is-invalid @enderror"
                                type="text" placeholder="Title" autocomplete="off" value="{{ settings('ceo_speech_title') }}">
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <input type="hidden" name="types[]" value="ceo_description">
                        <x-textarea name='ceo_description' placeholder='Write description' value="{{ settings('ceo_description') }}"/>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Title</label>
                        <input type="hidden" name="types[]" value="about_title">
                        <div class="input-group">
                            <input id="about_title" name="about_title" class="form-control"
                                type="text" placeholder="Title" autocomplete="off" value="{{ settings('about_title') }}">
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <input type="hidden" name="types[]" value="about_description">

                        <x-textarea name='about_description' placeholder='Write description' value="{{ settings('about_description') }}"/>
                    </div>

                    <h4 class="pt-3">About Our Service</h4>
                    <input type="hidden" name="types[]" value="service_icon">
                    <input type="hidden" name="types[]" value="service_title">
                    <input type="hidden" name="types[]" value="service_description">
                    @php
                        $services = is_array(json_decode(settings('service_title'))) ? json_decode(settings('service_title')) : [];
                        $descriptions = @json_decode(settings('service_description'));
                        $icons = @json_decode(settings('service_icon'));
                    @endphp
                    <div class="add-service">
                        @foreach ($services as $key => $title)
                        <div class="row">
                            {{-- <div class="col-3">
                                <label class="form-label">Icon</label>
                                <x-upload-file name="service_icon[]" fileType='image' value="{{ @$icons[$key] }}"/>
                            </div> --}}
                            <div class="col-4">
                                <label class="form-label">Title</label>
                                <div class="input-group">
                                    <input id="service_title" name="service_title[]" class="form-control"
                                        type="text" placeholder="Title" autocomplete="off" value="{{ @$title }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Description</label>
                                <div class="input-group">
                                    <textarea id="service_description" name="service_description[]" class="form-control service_description">{!! $descriptions[$key] !!}</textarea>
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
                            {{-- <div class="col-3">
                                <label class="form-label">Icon</label>
                                <x-upload-file name="service_icon[]" fileType='image'/>
                            </div> --}}
                            <div class="col-4">
                                <label class="form-label">Title</label>
                                <div class="input-group">
                                    <input id="service_title" name="service_title[]" class="form-control"
                                        type="text" placeholder="Title" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Description</label>
                                <div class="input-group">
                                    <textarea id="service_description" name="service_description[]" class="form-control service_description"></textarea>
                                </div>
                            </div>
                            <div class="col-2">
                                <label class="form-label">Remove</label> <br>
                                <button type="button" data-toggle="remove-parent" data-parent=".row" class="btn btn-danger"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        ' class="btn btn-success" data-target=".add-service"><i class="fa fa-plus"></i> Add More</button>
                    </div>
                    {{-- <h4 class="pt-3">Certificates</h4>

                    <div class="col-12">
                        <label class="form-label">Certificates</label>
                        <input type="hidden" name="types[]" value="certificates">
                        <x-upload-file name="certificates" fileType='image'  value="{{ settings('certificates') }}" multiple/>
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
