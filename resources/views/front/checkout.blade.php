@extends('layouts.front')

@section('title', 'Checkout')
    
@section('content')

<div class="container">

  <section class="py-5 bg-light">
    <div class="container">
      <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
        <div class="col-lg-6">
          <h1 class="h2 text-uppercase mb-0">Checkout</h1>
        </div>
        <div class="col-lg-6 text-lg-right">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-lg-end mb-0 px-0">
              <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
              <li class="breadcrumb-item"><a href="{{ route('front.cart') }}">Keranjang</a></li>
              <li class="breadcrumb-item active" aria-current="page">Checkout</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </section>

  <section class="py-5">
    <!-- BILLING ADDRESS-->
    <h2 class="h5 text-uppercase mb-4">Informasi Pengiriman</h2>
    <div class="row">
      <div class="col-lg-8">
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <form action="{{ route('front.prosesCheckout') }}" method="post">
          @csrf
          <div class="row">
            <div class="col-lg-12 form-group">
              <label class="text-small text-uppercase" for="name">Nama Lengkap</label>
              <input class="form-control form-control-lg @error ('customer_name') is-invalid @enderror"  id="customer_name" name="customer_name" type="text" value="{{ auth()->user()->customer->name }}" required>
              <p class="text-danger">{{ $errors->first('customer_name') }}</p>
            </div>
            <div class="col-lg-6 form-group">
              <label class="text-small text-uppercase" for="customer_phone">No Telp</label>
              <input class="form-control form-control-lg @error ('customer_phone') is-invalid @enderror"  name="customer_phone" type="text" value="{{ auth()->user()->customer->phone_number }}" required>
              <p class="text-danger">{{ $errors->first('customer_phone') }}</p>
            </div>
            <div class="col-lg-6 form-group">
              <label class="text-small text-uppercase" for="email">Email</label>
              <input class="form-control form-control-lg @error ('email') is-invalid @enderror"  name="email" type="email" value="{{ auth()->user()->email }}" readonly required>
              <p class="text-danger">{{ $errors->first('email') }}</p>
            </div>

            <div class="col-lg-12 form-group">
              <label class="text-small text-uppercase" for="customer_address">Alamat Lengkap</label>
              <input class="form-control form-control-lg @error ('customer_address') is-invalid @enderror"  name="customer_address" type="text"placeholder="Masukan alamat lengkap anda" required>
              <p class="text-danger">{{ $errors->first('customer_address') }}</p>
            </div>
            
            <div class="col-lg-12 form-group">
              <label class="text-small text-uppercase" for="province_id">Provinsi</label>
              <select name="province_id" id="province_id" class="form-control @error ('province_id') is-invalid @enderror">
                <option disabled selected>Pilih Provinsi</option>
                @foreach ($provinces as $province)
                <option value="{{ $province->id }}">{{ $province->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-lg-12 form-group">
              <label class="text-small text-uppercase" for="city_id">Kabupaten / Kota</label>
              <select name="city_id" id="city_id" class="form-control @error ('city_id') is-invalid @enderror">
                <option disabled selected>Pilih Kabupaten / Kota</option>
                
              </select>
            </div>

            <div class="col-lg-12 form-group">
              <label class="text-small text-uppercase" for="district_id">Kecamatan</label>
              <select name="district_id" id="district_id" class="form-control @error ('district_id') is-invalid @enderror">
                <option disabled selected>Pilih Kecamatan</option>

              </select>
            </div>
          </div>
        
      </div>
      <!-- ORDER SUMMARY-->
      <div class="col-lg-4">
        <div class="card border-0 rounded-0 p-lg-4 bg-light">

          <div class="card-body">
            <h5 class="text-uppercase mb-4">Pesanan Anda</h5>
            <ul class="list-unstyled mb-0">
              @foreach ($carts as $cart)
              <li class="d-flex align-items-center justify-content-between">
                <strong class="small font-weight-bold">{{ $cart['product_name'] }}</strong>
                <span class="text-muted small">{{ $cart['qty'] }}x</span>
                <span class="text-muted small">Rp {{ number_format($cart['qty'] * $cart['product_price']) }}</span>
              </li>
              <li class="border-bottom my-2"></li>  
              @endforeach
              <li class="d-flex align-items-center justify-content-between">
                <strong class="text-uppercase small font-weight-bold">Total</strong>
                <span><b>Rp {{ number_format($subtotal) }}</b></span>
              </li>
            </ul>
          </div>

          <div class="card-footer">
             <h6 class="text-uppercase mb-4"> Metode Pembayaran</h6>
            <div class="border p-3 mb-3">
             <h3 class="h6 mb-0">
               <a class="d-block text-decoration-none text-dark" data-toggle="collapse" href="#bca" role="button" aria-expanded="false" aria-controls="bca">BCA</a>
              </h3>
              <div class="collapse" id="bca">
                <div class="py-2">
                  <ul class="list-group ">
                    <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                      Moccaid :
                      <span>198 241 654</span>
                    </li>
                  </ul>
                </div>
              </div>
            </div>

            <div class="border p-3 mb-3">
             <h3 class="h6 mb-0">
               <a class="d-block text-decoration-none text-dark" data-toggle="collapse" href="#bri" role="button" aria-expanded="false" aria-controls="bri">BRI</a>
              </h3>
              <div class="collapse" id="bri">
                <div class="py-2">
                  <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                      Moccaid :
                      <span>251 263 625</span>
                    </li>
                  </ul>
                </div>
              </div>
            </div>

            <button class="btn btn-dark btn-block">Buat Pesanan</button>
            </form>
          </div>

        </div>
      </div>
       
     
    </div>
  </section>

</div>

@endsection

@section('js')

    <script>

      $('#province_id').on('click', function(){

        $.ajax({
          url:"{{ url('api/city') }}",
          type:"GET",
          data:{
            province_id : $(this).val()
          },
          success:function(html){
            $('#city_id').empty();
            $('#city_id').append('<option selected disable>Pilih Kabupaten / Kota</option>')
            $.each(html.data, function(key,item){
              $('#city_id').append(`<option value="`+ item.id +`">` + item.type + ' ' + item.name +`</option>`)
            });
          }
        });

      });

      $('#city_id').on('click', function(){

        $.ajax({
          url:"{{ url('api/district') }}",
          type:"GET",
          data:{
            city_id : $(this).val()
          },
          success:function(html){
            $('#district_id').empty();
            $('#district_id').append('<option selected disable>Pilih Kecamatan</option>')
            $.each(html.data, function(key,item){
              $('#district_id').append(`<option value="`+ item.id +`">`  + item.name +`</option>`)
            });
          }
        });

      });

    </script>

@endsection