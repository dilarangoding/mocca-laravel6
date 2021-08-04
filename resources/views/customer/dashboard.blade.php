@extends('layouts.front')

@section('title', 'Dashboard')

@section('content')


<div class="container">
  
  <section class="py-5 bg-light">
    <div class="container">
      <div class="row px-4 px-lg-5 py-lg-4">
        <div class="col-lg-12">
          <h1 class="h2 text-uppercase mb-0  text-center">Dashboard</h1>
        </div>
      </div>
    </div>
  </section>

  <section class="py-5">
    <div class="container p-0">
      <div class="row">
        <div class="col-lg-3 order-1">
          @include('layouts.front.customer')
        </div>
        <div class="col-lg-9 order-2">
          <div class="row">

            <div class="col-md-4">
              <div class="card text-center bg-light">
                <div class="card-body">
                  <h3>Belum Dibayar</h3>
                  <hr>
                  <p>Rp {{ number_format($order[0]->pending) }}</p>
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="card text-center bg-light">
                <div class="card-body">
                  <h3>Dikirim</h3>
                  <hr>
                  <p>{{ number_format($order[0]->shipping) }} Pesanan</p>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card text-center bg-light">
                <div class="card-body">
                  <h3>Selesai</h3>
                  <hr>
                  <p>{{ number_format($order[0]->completeOrder) }} Pesanan</p>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>

</div>


@endsection