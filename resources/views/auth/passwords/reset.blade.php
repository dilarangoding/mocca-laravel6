@extends('layouts.auth')

@section('title','Login')

@section('content')

<div class="login-box">
  <div class="card card-outline card-secondary">
    <div class="card-header text-center">
      <a href="{{ url('/') }}" class="h1 " style="color: #d0af72;"><b>Mocca</b>.id</a>
    </div>
    <div class="card-body text-dark">
      <p class="login-box-msg">Reset Password</p>

      <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="input-group mb-3">

             <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
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
          <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Konfirmasi Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-dark btn-block">Ubah Password</button>
          </div>
          
        </div>
      </form>

       <p class="mt-3 mb-1">
        <a href="{{ url('/login')}}" style="color: #d0af72;">Login</a>
      </p>
    </div>
  
  </div>
</div>


@endsection




