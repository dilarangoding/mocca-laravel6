@extends('layouts.front')

@section('title','Konfirmasi Pembayaran')

@section('css')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

@endsection

@section('content')

<div class="container">

   <section class="py-5 bg-light">
    <div class="container">
      <div class="row px-4 px-lg-5 py-lg-4">
        <div class="col-lg-12">
          <h1 class="h2 text-uppercase mb-0  text-center">Konfirmasi Pembayaran</h1>
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
              <div class="card">

                <div class="card-header">
                  <h4 class="card-title">Konfirmasi Pembayaran</h4>
                </div>

                <div class="card-body">
                  <form action="{{ route('customer.payment_store') }}" method="post" enctype="multipart/form-data">
                  @csrf
                   
                  @if (session('success'))
                     <div class="alert alert-success">{{ session('success') }}</div> 
                  @endif

                  @if (session('error'))
                      <div class="alert alert-danger">{{ session('error') }}</div>
                  @endif

                  <div class="form-group">
                    <label for="">Invoice</label>
                    <input type="text" readonly name="invoice" class="form-control" value="{{ request()->invoice }}" required>
                    <p class="text-danger">{{ $errors->first('invoice') }}</p>
                  </div>
                  <div class="form-group">
                    <label for="">Nama Pengirim</label>
                    <input type="text" name="name" class="form-control" placeholder="Masukan nama pengirim" value="{{ old('name') }}" required>
                    <p class="text-danger">{{ $errors->first('name') }}</p>
                  </div>
                  <div class="form-group">
                    <label for="">Transfer Ke</label>
                    <select name="transfer_to" id="transfer_to" class="form-control" required>
                      <option selected disabled>Pilih Tujuan Transfer</option>
                      <option value="BCA - 198 241 654">BCA - 198 241 654 : Moccaid</option>
                      <option value="BRI - 251 263 625">BRI - 251 263 625 : Moccaid</option>
                    </select>
                    <p class="text-danger">{{ $errors->first('transfer_to') }}</p>
                  </div>
                  <div class="form-group">
                    <label for="">Jumlah Transfer</label>
                    <input type="number" name="amount" class="form-control" placeholder="Masukan jumlah transfer" value="{{ old('amount') }}">
                    <p class="text-danger">{{ $errors->first('amount') }}</p>
                  </div>
                  <div class="form-group">
                    <label for="">Tanggal Transfer</label>
                    <input type="text" placeholder="dd-mm-yyyy" name="transfer_date" class="form-control" id="transfer_date" value="{{ old('transfer_date') }}">
                    <p class="text-danger">{{ $errors->first('transfer_date') }}</p>
                  </div>
                  <div class="form-group">
                    <label for="">Bukti Transfer</label>
                    <input type="file" name="proof" class="form-control" placeholder="Masukan jumlah transfer" value="{{ old('proof') }}">
                    <p class="text-danger">{{ $errors->first('proof') }}</p>
                  </div>
                  <div class="form-group">
                    <button class="btn btn-dark btn-block">Konfirmasi Pesanan</button>
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

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script>
      $('#transfer_date').datepicker({
          "todayHighlight": true,
          "setDate": new Date(),
          "autoclose": true
      })
    </script>
@endsection