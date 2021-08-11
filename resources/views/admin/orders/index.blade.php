@extends('layouts.admin')

@section('title','Pesanan Pelanggan')


@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Pesanan</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Pesanan </li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="container-fluid">
   
      <div class="row">

        <div class="col-md-12">
          <div class="card card-outline card-dark">
            
            <div class="card-header">
              <h4 class="card-title">
                List Pesanan
              </h4>

              <div class="card-tools float-right mb-2">
                  <form action="{{ route('orders.index') }}" method="get">


                    <div class="input-group input-group-sm" >
                      <select name="status" class="form-control mr-3">
                        <option selected disabled>Pilih status</option>
                        <option value="0">Baru</option>
                        <option value="1">Confirm</option>
                        <option value="2">Proses</option>
                        <option value="3">Dikirim</option>
                        <option value="4">Selesai</option>
                      </select>

                      <input type="text" name="q" value="{{ request()->q }}" class="form-control float-right" placeholder="Search">

                      <div class="input-group-append">
                        <button type="submit" class="btn btn-default">
                          Cari
                        </button>
                      </div>
                    </div>

                  </form>
              </div>
              
            </div>

            <div class="card-body">

              @if (session('success'))
                  <div class="alert alert-success">{{ session('success') }}</div>
              @endif
              @if (session('danger'))
                  <div class="alert alert-error">{{ session('danger') }}</div>
              @endif

            

              <div class="table-responsive">
                <table class="table table-bordered table-hover text-center text-nowrap">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>InvoiceId</th>
                      <th>Pelanggan</th>
                      <th>Subtotal</th>
                      <th>Tanggal Order</th>
                      <th>Status</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($orders as $item)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $item->invoice }}</td>
                      <td>
                        <strong>{{ $item->customer_name }}</strong><br>
                        <label><strong>Telp: </strong>{{ $item->customer_phone }}</label><br>
                        <label><strong>Alamat: </strong>{{ $item->customer_address }}</label>
                      </td>
                      <td>Rp {{ number_format($item->subtotal) }}</td>
                      <td>{{ $item->created_at->format('d-m-Y') }}</td>
                      <td>
                        {!! $item->status_label !!} <br>
                        @if ($item->return_count > 0 )
                        <a href="{{ route('orders.return', $item->invoice) }}">
                          <span class="badge badge-danger">
                            Permintaan return
                          </span>
                        </a> 
                        @endif
                      </td>
                      <td>
                        <form action="{{ route("orders.destroy", $item->id) }}" method="post">
                          @csrf
                          @method('DELETE')
                          <a href="{{ route('orders.detail', $item->invoice) }}"  class="btn btn-primary btn-sm ">Detail</a>
                          <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                      </td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="7" class="text-center">Tidak ada data</td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            {!! $orders->links() !!}
            </div>

          </div>
        </div>
        
      </div>

  </div>

</section>

@endsection

