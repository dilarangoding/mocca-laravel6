@extends('layouts.admin')

@section('title','Dashboard Admin')


@section('content')

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Dashboard</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Dashboard </li>
        </ol>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <div class="row">

      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-info elevation-1"><i class="fas fa-clock  nav-icon"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Total Produk</span>
            <span class="info-box-number">{{ $product }}</span>
          </div>
        </div>
      </div>
      
      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-truck"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Perlu Dikirim</span>
            <span class="info-box-number">{{ $order }}</span>
          </div>
        </div>
      </div>

      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-success elevation-1"><i class="fas fa-wallet"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Total Pendapatan</span>
            <span class="info-box-number">Rp {{ number_format($income) }}</span>
          </div>
        </div>
      </div>

      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-users"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Pelanggan Baru (H+7)</span>
            <span class="info-box-number">{{ $customer }}</span>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>
    
@endsection