@extends('backend.layouts.app')

@section('title')
Add Staff
@endsection

@section('content')
<div class="container-fluid">
    <div class="card mt-4" id="basic-info">
        <div class="card-header">
            <h5>Add Staff</h5>
        </div>
        <div class="card-body pt-0">
            <form action="{{ route('staff.store') }}" method="POST" enctype="multipart/form-data">
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
                    <div class="col-6">
                        <label class="form-label">Roles</label>
                        <select name="role_id" id="role_id" class="form-select">
                            <option value="" selected disabled>Select Role</option>
                            @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('role_id')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label class="form-label">Email</label>
                        <div class="input-group">
                            <input id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                type="email" placeholder="Email address" autocomplete="off" value="{{ old('email') }}">
                        </div>
                        @error('email')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label class="form-label">Phone</label>
                        <div class="input-group">
                            <input id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                type="text" placeholder="Phone" autocomplete="off" value="{{ old('phone') }}">
                        </div>
                        @error('phone')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <input id="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                type="password" placeholder="password" autocomplete="off" value="{{ old('password') }}">
                        </div>
                        @error('password')
                        <div class="text text-danger">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="text-center mt-2">
                        <button class="btn btn-success">Add Staff</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
