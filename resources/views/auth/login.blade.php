@extends('layouts.auth')

@section('title','Login')

@section('content')
<div class="login-box " style="margin-top:-130px;">
  <div class="login-logo ">
    <a href="{{ route('login') }}" style="color: #d0af72;"><h1>Mocca</h1></a>
  </div>
  <div class="card">
    <div class="card-body login-card-body">
      <h2 class="login-box-msg" >Login</h2>

      <form method="POST" action="{{ route('login') }}">
         @csrf
        <div class="input-group mb-3">
          <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="off" placeholder="Email" autofocus>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
            @error('email')
             <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
             </span>
            @enderror
        </div>

        <div class="input-group mb-3">
          <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
          @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="input-group mb-3">
            <button class="btn btn-dark btn-block">Login</button>
        </div>
        
      </form>
    
      @if (Route::has('password.request'))                             
      <p class="mb-1">
        <a href="{{ route('password.request') }}" style="color: #bb9d66;">{{ __('Lupa Password Anda?') }}</a>
      </p>
      @endif

      <p class="mb-0">
        <a href="{{ route('register') }}" class="text-center" style="color: #bb9d66;">Daftar Akun Baru</a>
      </p>

    </div>
  </div>
</div>
@endsection
