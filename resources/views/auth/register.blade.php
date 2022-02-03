@extends('layouts.app')
@section('content')
<div class="auth-form-light text-left py-5 px-4 px-sm-5">
    <div class="brand-logo">
      <img src="{{asset('assets/images/logo-dark.svg')}}" alt="logo">
    </div>
    <h4>New here?</h4>
    <h6 class="font-weight-light">Signing up is easy. It only takes a few steps</h6>
    <form class="pt-3" method="POST" action="{{ route('register') }}">
    @csrf
      <div class="form-group">
        <input id="name" type="text" placeholder="Username" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
      </div>
      <div class="form-group">
        <input id="email" type="email" placeholder="Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
      </div>
      <div class="form-group">
        <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
      </div>
      <div class="form-group">
        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">
      </div>
      <div class="mb-4">
        <div class="form-check">
          <label class="form-check-label text-muted">
            <input type="checkbox" class="form-check-input">
            I agree to all Terms & Conditions
          </label>
        </div>
      </div>
      <div class="mt-3">
        <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
            {{ __('Register') }}
        </button>
      </div>
      <div class="text-center mt-4 font-weight-light">
        Already have an account? <a href="{{ route('login') }}" class="text-primary">Login</a>
      </div>
    </form>
  </div>
  @endsection