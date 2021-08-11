@extends('layouts.admin')

@section('title','Pelanggan')


@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Pelanggan</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Pelanggan </li>
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
              <h4 class="card-title">List Pelanggan</h4>
            </div>

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-hover text-center">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama </th>
                      <th>No Telpn</th>
                      <th>Jumlah Order</th>
                      <th>Email</th>
                      <th>Verifikasi</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($customers as $item)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $item->name }}</td>
                      <td>{{ $item->phone_number }}</td>
                      <td>{{ $item->order_count }}</td>
                      <td>{{ $item->user->email }}</td>
                      <td>{!! $item->user->verify_label !!}</td>
                      <td>
                        <form action="{{ route("customers.destroy", $item->id) }}" method="post">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                      </td>
                    </tr>   
                    @empty
                    <tr>
                      <td colspan="6" class="text-center">Tidak ada data</td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
  
          </div>
        </div>
        
      </div>

  </div>

</section>

@endsection

