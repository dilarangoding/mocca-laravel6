@extends('layouts.admin')

@section('title','Detail Pesanan')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Detail Pesanan</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Detail Pesanan</li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="container-fluid">

    <div class="row">

      <div class="col-md-12">
        
        @if (session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>  
        @endif

        <div class="card card-outline card-dark">

          <div class="card-header">

            <h4 class="card-title">
              Detail Pesanan
            </h4>

            <div class="card-tools float-right">
              @if ($order->status == 1 && $order->payment->status == 0)
              <a href="{{ url('admin/orders/accept_payment', $order->id)}}" class="btn btn-sm btn-primary">Terima Pesanan</a>
              @endif
            </div>         

          </div>

          <div class="card-body">
            <div class="row">

              <div class="col-md-6">
                <h4>Data Pelanggan</h4>
                <table class="table table-bordered">
                  <tr>
                    <td width="40%">Nama Pelanggan</td>
                    <th>{{ $order->customer_name }}</th>
                  </tr>
                  <tr>
                    <td>No Telp</td>
                    <th>{{ $order->customer_phone }}</th>
                  </tr>
                  <tr>
                    <td>Alamat</td>
                    <th>{{ $order->customer_address }}, Kecamatan  {{ $order->district->name }},
                      {{ $order->district->city->type }} {{ $order->district->city->name }},
                      {{ $order->district->city->province->name }}
                    </th>
                  </tr>
                  <tr>
                    <td>Order Status</td>
                    <td>{!! $order->status_label !!}</td>
                  </tr>
                  @if ($order->status > 1)
                  <tr>
                    <td>Nomor Resi</td>
                    <td>
                      @if ($order->status == 2)
                      <form action="{{ route('orders.tracking_number') }}" method="post">
                      @csrf
          
                      <div class="input-group">
                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                        <input type="text" name="tracking_number" placeholder="Masukan no resi" class="form-control">
                        <div class="input-group-append">
                          <button type="submit" class="btn btn-default">
                            Kirim
                          </button>
                        </div>
                      </div>
                      </form> 
                      @else
                      {{ $order->tracking_number }}
                      @endif
                    </td>
                  </tr>
                  @endif
                </table>
              </div>

              <div class="col-md-6 ">
                <h4>Detail Pembayaran</h4>
          
                @if($order->status != 0)
          
                <table class="table table-bordered">
                  <tr>
                    <td width="40%">Nama Pengirim</td>
                    <th>{{ $order->payment->name }}</th>
                  </tr>
                  <tr>
                    <td>Bank Tujuan</td>
                    <th>{{ $order->payment->transfer_to }}</th>
                  </tr>
                  <tr>
                    <td>Tanggal Transfer</td>
                    <th>{{ $order->payment->transfer_date }}</th>
                  </tr>
                  <tr>
                    <td>Bukti Transfer</td>
                    <th><a href="{{ asset('asset/payment/' . $order->payment->proof) }}" target="_blank">Lihat</a></th>
                  </tr>
                  <tr>
                    <td>Status</td>
                    <th>{!! $order->payment->status_label !!}</th>
                  </tr>
                  
                </table>
          
                @else
          
                @endif
              </div>

              <div class="col-md-12 mt-3">
                <div class="card card-outline card-dark">
                  <div class="card-header">
                    <h4 class="card-title">
                      Detail Produk
                    </h4>
                  </div>
                  <div class="card-body">
                    <table class="table table-bordered table-hover text-center">
                        <thead>
                          <tr>
                            <th>Produk</th>
                            <th>Kuantitas</th>
                            <th>Harga</th>
                            <th>Berat</th>
                            <th>Subtotal</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($order->orderDetail as $item)
                          <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>{{ $item->price }}</td>
                            <td>{{ $item->weight }} gr</td>
                            <td>Rp{{ number_format($item->price * $item->qty)  }}</td>
                          </tr>   
                          @endforeach
                        </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="4" class="bg-light text-center">Total</td>
                            <th>Rp {{ number_format($order->subtotal) }}</th>
                          </tr>
                        </tfoot>
                      </table>
              
                  </div>
                </div>
              </div>

            </div>
          </div>

        </div>

      </div>

    </div>

  </div>
</section>
    
@endsection

