@extends('layouts.app')

@section('title','Register')
@section('content')
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<div class="loginfrom">
    <div>
        <img src="{{ asset('frontend') }}/assets/img/logo.png" alt="">
        <p>Welcome back! login with your date that you entered during registraion </p>
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control @error('name')
                    is-invalid
                @enderror" name='name' id="name"
                    placeholder="Enter name" value="{{ old('name') }}">
                @error('name')
                    <div class="text text-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="text" class="form-control @error('email')
                    is-invalid
                @enderror" name='email' id="email"
                    placeholder="Enter email address or username" value="{{ old('email') }}">
                @error('email')
                    <div class="text text-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control @error('password')
                    is-invalid
                @enderror" name='password' id="password" placeholder="Password">
                @error('password')
                    <div class="text text-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" class="form-control @error('password_confirmation')
                    is-invalid
                @enderror" name='password_confirmation' id="password_confirmation" placeholder="Password">
                @error('password_confirmation')
                    <div class="text text-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group form-check">
                <a href="{{ route('password.request') }}" class="forgetpass">Forget password</a>
            </div>
            <button type="submit" class="btn btn-default submit">Sign Up</button>
        </form>
        <div class="frombottom">
            <p class="or">or</p>
            <a href="{{ route('social.redirect','google') }}" class="continewwidthgogle text-decoration-none">
                <img src="{{ asset('frontend') }}/assets/img/google-logo-9824.png" alt=""> Continue With Google
            </a>
            <a href="{{ route('register') }}" class="donthave text-decoration-none">Have a account? Log In</a>
        </div>
    </div>
</div>
@endsection
