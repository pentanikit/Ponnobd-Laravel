@extends('layouts.app')
@section('title','Login')
@section('content')
<div class="loginfrom">
    <div>
        <div class="text-center">
            <img style="width: 180px;margin-left:35px" src="{{ uploadedFile(settings('header_logo')) }}" alt="Logo" loading="lazy">
        </div>
        <p>Welcome back! login with your date that you entered during registraion </p>
        <form action="{{ route('login') }}" method="POST">
            @csrf
            @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="form-group">
                <label for="email">Email address Or Phone</label>
                <input type="text" class="form-control @error('email')
                    is-invalid
                @enderror" name='email' id="email"
                    placeholder="Enter email address or phone" value="{{ old('email') }}">
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
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="remember">
                <label class="form-check-label" for="remember">Remember me</label>
                <a href="{{ route('password.request') }}" class="forgetpass">Forget password</a>
            </div>
            <button type="submit" class="btn btn-default submit">Login</button>
        </form>
        <div class="frombottom">
            {{-- <p class="or">or</p>
            <a href="{{ route('social.redirect','google') }}" class="continewwidthgogle text-decoration-none">
                <img src="{{ asset('frontend') }}/assets/img/google-logo-9824.png" alt=""> Continew With Google
            </a> --}}
            <a href="{{ route('register') }}" class="donthave text-decoration-none">Don't have a account? Sign Up</a>
        </div>
    </div>
</div>
@endsection
