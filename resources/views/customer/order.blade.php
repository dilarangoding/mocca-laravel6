@extends('layouts.front')

@section('title', 'Dashboard')

@section('content')

<div class="container">

  <section class="py-5 bg-light">
    <div class="container p-0">
      <div class="row px-4 px-lg-5 py-lg-4">
        <div class="col-lg-12">
          <h1 class="h2 text-uppercase mb-0  text-center">Pesanan Anda</h1>
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
                 <div class="alert alert-success">{{ session("success") }}</div>
             @endif
             <div class="card">

               <div class="card-header">
                 <h4 class="card-title">List Pesanan</h4>
               </div>

               <div class="card-body">
                 <div class="table-responsive">
                   <table class="table table-bordered table-hover text-center text-nowrap">
                     <thead>
                       <tr>
                         <th>Invoice</th>
                         <th>Penerima</th>
                         <th>No Telp</th>
                         <th>Total</th>
                         <th>Status</th>
                         <th>Tanggal</th>
                         <th>Aksi</th>
                       </tr>
                     </thead>
                     <tbody>
                       @forelse ($orders as $item)
                       <tr>
                         <td><strong>{{ $item->invoice }}</strong></td>
                         <td>{{ $item->customer_name }}</td>
                         <td>{{ $item->customer_phone }}</td>
                         <td>Rp {{ number_format($item->subtotal) }}</td>
                         <td>{!! $item->status_label !!}</td>
                         <td>{{ $item->created_at->format('d-m-Y') }}</td>
                         <td>
                           @if ($item->status == 0)
                              <a href="{{ url('/payment?invoice=' . $item->invoice) }}" class="btn btn-info btn-sm">Konfirmasi</a>
                           @endif
                           <form action="{{ route('customer.order_accept') }}" method="POST" onsubmit="return confirm('Sudah yakin barang nya sesuai?')">
                            @csrf

                            <input type="hidden" name="order_id" value="{{ $item->id }}">
                            @if ($item->status == 3 && $item->return_count == 0)
                            <button class="btn btn-sm btn-success">Terima Barang</button>  
                            
                            <a href="{{ route('customer.order_return', $item->invoice) }}" class="btn btn-sm btn-danger">Return</a>
                            @endif

                            <a href="#" data-id="{{ $item->invoice }}" class="btn btn-dark btn-sm btn-rounded  detail">Detail</a>


                           </form>
                         </td>
                       </tr>
                       @empty
                       <tr>
                         <td colspan="7">Tidak Ada Pesanan</td>
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
      </div>
    </div>
  </section>

</div>


{{-- Modal --}}

<!-- modal -->
	<div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Detail Pesanan</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
					<div class="modal-body">

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
					</div>
			</div>
		</div>
	</div>

{{-- End Modal --}}
@endsection

@section('js')
  <script>

    $(".detail").on('click', function(){
      const id = $(this).data('id');
      let  url = "{{ url('pesanan/') }}/" + id; 
  
      $.ajax({
        url:url,
        method: "GET",
        success: function(data){
          
          $("#modal-detail").find(".modal-body").html(data)
					$("#modal-detail").modal('show')
        }
      });

    });

  </script>
@endsection