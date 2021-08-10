@extends('layouts.front')

@section('title','Pengaturan')

@section('content')

<div class="container">

  <section class="py-5 bg-light">
    <div class="container">
      <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
        <div class="col-lg-6">
          <h1 class="h2 text-uppercase mb-0">Pengaturan</h1>
        </div>
        <div class="col-lg-6 text-lg-right">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-lg-end mb-0 px-0">
              <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
              <li class="breadcrumb-item active" aria-current="page">Pengaturan</li>
            </ol>
          </nav>
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
                <div class="alert alert-success">
                 {{ session('success') }}
                </div>
              @endif
              @if (session('error'))
                <div class="alert alert-danger">
                 {{ session('error') }}
                </div>
              @endif
              <div class="card">

                <div class="card-header">
                  <h4 class="card-title">Pengaturan Akun</h4>
                </div>

                <div class="card-body">
                  <form action="{{ route('customer.setting') }}" method="post">
                    @csrf

                    <div class="form-group">
                      <label for="name">Nama Lengkap</label>
                      <input type="text" name="name" class="form-control @error ('name') is-invalid @enderror" value="{{ $customer->name }}">
                      <p class="text-danger">{{ $errors->first("name") }}</p>
                    </div>

                    <div class="form-group">
                      <label for="email">Email</label>
                      <input type="text" readonly class="form-control" value="{{ auth()->user()->email }}">
                    </div>

                    <div class="form-group">
                      <label for="password">Password <sup class="text-danger">*kosongkan jika tidak ingin mengubah password</sup></label>
                      <input type="password" name="password" class="form-control @error ('password') is-invalid @enderror"  placeholder="**********">
                      <p class="text-danger">{{ $errors->first("password") }}</p>
                    </div>

                    <div class="form-group">  
                      <label for="">No Telp</label>
                      <input type="number" name="phone_number" class="form-control @error ('phone_number') is-invalid @enderror" value="{{ $customer->phone_number }}">
                      <p class="text-danger">{{ $errors->first('phone_number') }}</p>
                    </div>

                    <div class="form-group">  
                      <label for="">Alamat</label>
                      <input type="text" name="address" class="form-control @error ('address') is-invalid @enderror" value="{{ $customer->address }}">
                      <p class="text-danger">{{ $errors->first('address') }}</p>
                    </div>

                    <div class="form-group">  
                      <label for="">Provinsi</label>
                      <select name="province_id" class="form-control @error ('province_id') is-invalid @enderror" id="province_id">
                        <option >Pilih Provinsi</option>
                        @foreach ($provinces as $item)
                        <option value="{{ $item->id }}" {{ $customer->district->province_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>   
                        @endforeach
                      </select>
                      <p class="text-danger">{{ $errors->first('province_id') }}</p>
                    </div>

                    <div class="form-group">
                      <label for="">Kabupaten / Kota</label>
                      <select name="city_id" id="city_id" class="form-control">
                        <option >Pilih Kabupaten / Kota</option>
                      </select>
                      <p class="text-danger">{{ $errors->first('city_id') }}</p>
                    </div>

                    <div class="form-group">
                      <label for="">Kecamatan</label>
                      <select name="district_id" id="district_id" class="form-control">
                        <option >Pilih Kecamatan</option>
                      </select>
                      <p class="text-danger">{{ $errors->first('district_id') }}</p>
                    </div>

                    <div class="form-group">
                      <button class="btn btn-dark btn-block">Simpan</button>
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
  <script>

      //JADI KETIKA HALAMAN DI-LOAD
        $(document).ready(function(){
            //MAKA KITA MEMANGGIL FUNGSI LOADCITY() DAN LOADDISTRICT()
            //AGAR SECARA OTOMATIS MENGISI SELECT BOX YANG TERSEDIA
            loadCity($('#province_id').val(), 'bySelect').then(() => {
                loadDistrict($('#city_id').val(), 'bySelect');
            })
        })

        $('#province_id').on('change', function() {
            loadCity($(this).val(), '');
        })

        $('#city_id').on('change', function() {
            loadDistrict($(this).val(), '')
        })

        function loadCity(province_id, type) {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: "{{ url('/api/city') }}",
                    type: "GET",
                    data: { province_id: province_id },
                    success: function(html){
                        $('#city_id').empty()
                        $('#city_id').append('<option value="">Pilih Kabupaten/Kota</option>')
                        $.each(html.data, function(key, item) {    
                            let city_selected = {{ $customer->district->city_id }};
                            let selected = type == 'bySelect' && city_selected == item.id ? 'selected':'';
                            $('#city_id').append(`<option value="`+item.id+`" `+ selected +`>`+ item.type + ' '+item.name+`</option>`)
                            resolve()
                        })
                    }
                });
            })
        }

        
        function loadDistrict(city_id, type) {
            $.ajax({
                url: "{{ url('/api/district') }}",
                type: "GET",
                data: { city_id: city_id },
                success: function(html){
                    $('#district_id').empty()
                    $('#district_id').append('<option value="">Pilih Kecamatan</option>')
                    $.each(html.data, function(key, item) {
                        let district_selected = {{ $customer->district->id }};
                        let selected = type == 'bySelect' && district_selected == item.id ? 'selected':'';
                        $('#district_id').append('<option value="'+item.id+'" '+ selected +'>'+item.name+'</option>')
                    })
                }
            });
        }
    
  </script>
@endsection
