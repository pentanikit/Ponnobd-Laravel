@extends('backend.layouts.app')

@section('title')
Edit Value
@endsection
@section('content')
<div class="row">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">Edit Attribute</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('attribute.value.update',$value->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Value</label>
                        <input type="text" placeholder="Attribute Value.." id="value" name="value" value="{{ $value->value }}" class="form-control @error('value') is-invalid @enderror">
                        @error('value')
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
