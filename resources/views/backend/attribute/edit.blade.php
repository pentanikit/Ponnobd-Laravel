@extends('backend.layouts.app')

@section('title')
Edit Attribute
@endsection
@section('content')
<div class="row">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">Edit Attribute</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('attribute.update',$attribute->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" placeholder=" Name.." id="name" name="name" value="{{ $attribute->name }}" class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
