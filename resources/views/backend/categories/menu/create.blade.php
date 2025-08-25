@extends('backend.layouts.app')

@section('title')
Add Menu
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
            <h5>Add Menu</h5>
        </div>
        <div class="card-body pt-0">
            <form action="{{ route('categories.menus.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-6">
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

                    <div class="col-6 @error('parent_id') border-danger @enderror">
                        <div class="input-area">
                            <label class="form-label">Parent</label>
                            <x-select name="parent_id">
                                <option value="" selected disabled>Select Parent Menu</option>
                                @foreach ($menus as $menu)
                                <option value="{{ $menu->id }}" @selected($menu->id == old('parent_id'))>{{ $menu->name }}</option>
                                @endforeach
                            </x-select>
                        </div>
                        @error('parent_id')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label class="form-label">URL</label>
                        <div class="input-group">
                            <input id="url" name="url" class="form-control @error('url') is-invalid @enderror"
                                type="url" placeholder="URL" autocomplete="off" value="{{ old('url') }}">
                        </div>
                        @error('url')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label class="form-label">Target</label>
                        <div class="input-group">
                            <select name="target" id="target" class="form-select @error('target') is-invalid @enderror">
                                <option value="_self" selected>Self</option>
                                <option value="_blank">Blank</option>
                            </select>
                        </div>
                        @error('target')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label class="form-label">Icon</label> <br>
                        <small><a href="https://icons.getbootstrap.com/" class="text-decoration-underline">Go to Icon site</a> and choose icon. Copy the class name. Like <b>bi-tv</b></small>
                        <div class="input-group">
                            <input id="icon" name="icon" class="form-control @error('icon') is-invalid @enderror"
                                type="text" placeholder="Icon class name" autocomplete="off" value="{{ old('icon') }}">
                        </div>
                        @error('icon')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="text-center mt-2">
                        <button class="btn btn-success">Add Menu</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
