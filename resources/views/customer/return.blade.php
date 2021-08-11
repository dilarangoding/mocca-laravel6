@extends('layouts.front')

@section('title', 'Return Pesanan')

@section('content')


<div class="container">
  
  <section class="py-5 bg-light">
    <div class="container">
      <div class="row px-4 px-lg-5 py-lg-4">
        <div class="col-lg-12">
          <h1 class="h2 text-uppercase mb-0  text-center">Return Pesanan</h1>
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

           <div class="col-md-12">
             @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>   
             @endif

             @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>   
             @endif
             <div class="card">
               <div class="card-header">
                 <h4 class="card-title">Return Pesanan</h4>
               </div>
               <div class="card-body">
                 <form action="{{ route('customer.return', $order->id) }}" enctype="multipart/form-data" method="post">
                   @csrf
                   <input type="hidden" name="_method" value="PUT">
                   <div class="form-group">
                     <label for="">Alasan return pesanan</label>
                     <textarea name="reason" id="reason" cols="5" placeholder="Masukan alasan" rows="3" class="form-control" required></textarea>
                     <p class="text-danger">{{ $errors->first('reason') }}</p>
                   </div>
                   
                   <div class="form-group">
                     <label for="">Rekening Pengembalian Dana</label>
                     <input type="text" placeholder="Rekening Pengembalian Dana" name="refund_transfer" class="form-control" required>
                     <p class="text-danger">{{ $errors->first('refund_transfer') }}</p>
                   </div>

                   <div class="form-group">
                     <label for="">Foto Barang</label>
                     <input type="file" name="photo" class="form-control" required>
                     <p class="text-danger">{{ $errors->first('photo') }}</p>
                   </div>
                   
                   <div class="form-group">
                     <button class="btn btn-dark btn-block">Kirim</button>
                   </div>
                 </form>
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