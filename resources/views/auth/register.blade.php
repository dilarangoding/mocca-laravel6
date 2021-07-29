@extends('layouts.auth')
@section('title','Registrasi')
@section('content')
<div class="register-box">
  <div class="card" style="border-top: 2px solid #d0af72;">
    <div class="card-header text-center">
      <h1 style="color: #d0af72;">Mocca</h1>
    </div>
    <div class="card-body register-card-body">
      <form method="POST" action="{{ route('register') }}">
        @csrf   
        <div class="input-group mb-3">
          <input type="text" class="form-control @error('name') is-invalid @enderror"
           value="{{ old('name') }}" name="name" placeholder="Nama Lengkap" autocomplete="name">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
          @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
        <div class="input-group mb-3">
          <input type="email" class="form-control @error('email') is-invalid @enderror"
           value="{{ old('email') }}" name="email" placeholder="Email">
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
          <input type="text" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror"
           value="{{ old('phone_number') }}" placeholder="No Telphone">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-phone"></span>
            </div>
          </div>
          @error('phone_number')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control @error('password') is-invalid @enderror"
           value="{{ old('password') }}" name="password" placeholder="Password">
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
          <input type="password" class="form-control @error('password') is-invalid @enderror"
           value="{{ old('password') }}" name="password_confirmation" placeholder="Ulangi password">
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
          <button class="btn btn-dark btn-block" type="submit">Registrasi</button>
        </div>
      </form>

      <a href="{{ route('login') }}" class="text-center" style="color: #d0af72;">Saya sudah punya akun</a>
    </div>
  </div>
</div>
@endsection