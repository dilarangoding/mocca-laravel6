@extends('layouts.admin')

@section('title','Laporan Pesanan')


@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Laporan Pesanan</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Laporan Pesanan </li>
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
              <h4 class="card-title">Laporan</h4>

               <div class="card-tools float-right mb-2">
                  <form action="{{ route('report.index') }}" method="get">
                
                    <div class="input-group input-group-sm" style="width:250px;">
                      <input type="text" name="date"  id="date" class="form-control float-right" placeholder="Search">

                   
                      <a  class="btn btn-danger btn-sm ml-2" id="exportPdf" target="_blank">Export PDF</a>
                    </div>
                  </form>
               </div>
            </div>

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-hover text-center">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Invoice</th>
                      <th>Pelanggan</th>
                      <th>Subtotal</th>
                      <th>Tanggal</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($orders as $item)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td><strong>{{ $item->invoice }}</strong></td>
                      <td>
                        <strong>{{ $item->customer_name }}</strong><br>
                        <label><strong>Telp:</strong> {{ $item->customer_phone }}</label><br>
                        <label><strong>Alamat:</strong> {{ $item->customer_address }} </label>
                      </td>
                      <td>Rp {{ number_format($item->subtotal) }}</td>
                      <td>{{ $item->created_at->format('d-m-Y') }}</td>
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

@section('js')

   <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js">
    </script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <script>
      $(document).ready(function(){
        let start = moment().startOf('month');
        let end   = moment().endOf('month');
        let url   = "{{ url('admin/laporan/pdf/') }}";
        
        
        $('#exportPdf').attr('href',  url + '/' + start.format('YYYY-MM-DD') + '+' + end.format('YYYY-MM-DD'));

        $('#date').daterangepicker({
          startDate:start,
          endDate:end,
        }, function(first, last){
          $('#exportPdf').attr('href',   url + '/' + first.format('YYYY-MM-DD') + '+' + last.format('YYYY-MM-DD'));

        });
      });
    </script>
    
@endsection

