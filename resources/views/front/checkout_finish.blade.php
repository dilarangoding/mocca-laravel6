@extends('layouts.front')

@section('title','Pesanan Berhasil')

@section('content')

<div class="container">
  <section class="py-5 bg-light">
    <div class="container">
      <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
        <div class="col-lg-12 text-center ">
          <h1 class="h2 text-uppercase mb-5">Pesanan Selesai</h1>
          <h4>Silahkan untuk melakukan konfirmasi pembayaran atau klik <a href="#">disini</a> sebelum </h4>
          <br>
          <h4>14:54  1 Agustus 2021  </h4>
        </div>
      </div>
    </div>
  </section>
  
  <section class="py-5">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <table class="table table-bordered text-center">
            <thead>
              <tr>
                <th>Gambar</th>
                <th>Produk</th>
                <th>Kuantitas</th>
                <th>Subtotal</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($order->orderDetail as $item)
                <tr>
                  <td>
                    <img src="{{ asset('asset/produk/' .$item->product->image) }}" alt="" width="100">
                  </td>
                  <td>{{ $item->product->name }}</td>
                  <td>{{ $item->qty }}</td>
                  <td>Rp {{ number_format($item->price * $item->qty) }}</td>
                </tr>
              @endforeach
            </tbody>
            <tfoot class="bg-light">
              <tr>
                <th colspan="3">Invoice</th>
                <th>{{ $order->invoice }}</th>
              </tr>
              <tr>
                <th colspan="3">Total</th>
                <th>Rp {{ number_format($order->subtotal) }}</th>
              </tr>
            </tfoot>
        </table>
      </div>
    </div>
    <div class="row justify-content-center">
      <a class="btn btn-outline-dark btn-sm" href="{{ route('front.product') }}">
        <i class="fas fa-long-arrow-alt-left mr-2"></i>
        Lanjut Belanja
      </a>
       <a class="btn btn-outline-dark btn-sm ml-5" href="{{ route('front.product') }}">
        Konfirmasi pembayaran
        <i class="fas fa-long-arrow-alt-right mr-2"></i>
      </a>
    </div>
  </section>
</div>

@endsection