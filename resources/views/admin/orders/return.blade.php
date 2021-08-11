@extends('layouts.admin')

@section('title','Return Pesanan')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Return Pesanan</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Return Pesanan</li>
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
              Return Pesanan
            </h4>    

          </div>

          <div class="card-body">
            <div class="row">

              <div class="col-md-6">
                <h4 class="mb-4">Detail Pelanggan</h4>
                <table class="table table-bordered">
                  <tr>
                    <td width="45%">Nama Pelanggan</td>
                    <th>{{ $order->customer->name }}</th>
                  </tr>
                  <tr> 
                    <td>Telp</td>
                    <td>{{ $order->customer->phone_number }}</td>
                  </tr>
                  <tr>
                    <td>Alasan Return</td>
                    <td>{{ $order->return->reason }}</td>
                  </tr>
                  <tr>
                    <td>Rekening Pengembalian Dana</td>
                    <td>{{ $order->return->refund_transfer }}</td>
                  </tr>
                  <tr>
                    <td>Status</td>
                    <td>{!! $order->return->status_label !!}</td>
                  </tr>
                </table>
                
                @if ($order->return->status == 0)
                <form action="{{ route('orders.approve_return') }}" onsubmit="return confirm('yakin?')" method="post">
                  @csrf
                  <input type="hidden" name="order_id" value="{{ $order->id }}">
                  <div class="input-group ">

                    <select name="status" class="form-control" id="">
                      <option selected disabled>Pilih</option>
                      <option value="1">Terima</option>
                      <option value="2">Tolak</option>
                    </select>

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default">
                        Kirim
                      </button>
                    </div>
                  </div>
                </form>

                    
                @endif
              </div>

              <div class="col-md-6 text-center ">
                <h4 class="mb-4">Foto Barang Return</h4>  
                  <img src="{{ asset('asset/return/' . $order->return->photo) }}" alt="{{ $order->return->photo }}" height="200" class="img-responsive ">
              </div>

            </div>
          </div>

        </div>

      </div>

    </div>

  </div>
</section>
    
@endsection

