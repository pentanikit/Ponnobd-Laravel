@extends('backend.layouts.app')

@section('title')
Update Profile
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">Profile Update</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" placeholder="Name" id="name" name="name" value="{{ user('name') }}"
                                    class="form-control @error('name') is-invalid @enderror">
                                @error('name')
                                <div class="text text-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" placeholder="email" id="email" name="email" value="{{ user('email') }}"
                                    class="form-control @error('email') is-invalid @enderror">
                                @error('email')
                                <div class="text text-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" placeholder="username" id="username" name="username" value="{{ user('username') }}"
                                    class="form-control @error('username') is-invalid @enderror" disabled>
                                @error('username')
                                <div class="text text-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">Change Password</label>
                                <input type="password" placeholder="password" id="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror">
                                @error('password')
                                <div class="text text-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
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
