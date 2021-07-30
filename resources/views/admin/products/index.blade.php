@extends('layouts.admin')

@section('title', 'Produk')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Produk</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Produk </li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="container-fluid">
    <div class="animated fadeIn">
      <div class="row">

        <div class="col-md-12">
          <div class="card card-outline card-dark">
            
            <div class="card-header">
              <h4 class="card-title">
                List Produk
              </h4>
              <a href="{{  route('product.create')  }}" class="btn btn-dark btn-sm float-right">Tambah</a>
              
            </div>

            <div class="card-body">

              @if (session('success'))
                  <div class="alert alert-success">{{ session('success') }}</div>
              @endif
              @if (session('danger'))
                  <div class="alert alert-error">{{ session('danger') }}</div>
              @endif

              <div class="card-tools float-right mb-2">
                  <form action="{{ route('product.index') }}" method="get">
                
                    <div class="input-group input-group-sm" style="width:180px;">
                      <input type="text" name="q" value="{{ request()->q }}" class="form-control float-right" placeholder="Search">

                      <div class="input-group-append">
                        <button type="submit" class="btn btn-default">
                          <i class="fas fa-search"></i>
                        </button>
                      </div>
                    </div>
                  </form>
              </div>

              <div class="table-responsive">
                <table class="table table-bordered table-hover text-center text-nowrap">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Produk</th>
                      <th>Gambar</th>
                      <th>Harga</th>
                      <th>Deskripsi</th>
                      <th>Status</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($product as $item)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>
                        <strong>{{ $item->name }}</strong><br>
                        <label for="">Kategori :
                           <span class="badge badge-info">{{ $item->category->name }}</span>
                        </label><br>
                        <label for="">Berat:
                          <span class="badge badge-dark">{{ $item->weight }} gr</span>
                        </label>
                      </td>
                      <td>
                        <img src="{{ asset('asset/produk/'. $item->image) }}" alt="{{ $item->name }}" width="100">
                      </td>
                      <td>
                        Rp {{ number_format($item->price) }}
                      </td>
                      <td>
                        {!! Str::limit($item->description, 20) !!}
                      </td>
                      <td>
                        {!! $item->status_label !!}
                      </td>
                      <td>
                        <form action="{{ route('product.destroy', $item->id) }}" method="post">
                          @csrf
                          @method('DELETE')
                          <a href="#" data-toggle="modal" data-id={{ $item->id }} data-target="#exampleModal" class="btn btn-secondary btn-sm viewData">View</a>
                          <a href="{{ route("product.edit" ,$item->id) }}" class="btn btn-warning btn-sm">
                            Edit
                          </a>
                          <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                      </td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="7">Tidak ada data</td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
              {!! $product->links() !!}
            </div>

          </div>
        </div>
        
      </div>
    </div>
  </div>
</section>


{{-- Modal --}}
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@endsection


@section('js')
    <script>
      $('.viewData').on('click', function(){
       const id = $(this).data('id');
       const url = "{{ asset('asset/produk/') }}"

        $.ajax({
          url:"{{ url('/api/showProduct/') }}",
          type: "GET",
          data: { id : id},
          success: function(data){
              let product = data.product;
              let category = data.category;
              
              $('.modal-title').html(product.name);
              $('.modal-body').html(`
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-md-4  d-flex align-items-center">
                      <img src="` + url + '/' + product.image + `" class="img-fluid">
                    </div>
                    <div class="col-md-8">
                      <ul class="list-group">
                        <li class="list-group-item"><h4><b>`+ product.name +`</b></h4></li>
                        <li class="list-group-item">Harga : `+ parseInt(product.price).toLocaleString()+`</li>
                        <li class="list-group-item">Kategori : `+ category.name +`</li>
                        <li class="list-group-item">Berat : `+ product.weight +`</li>
                        <li class="list-group-item">Deksripsi : `+ product.description +`</li>
                        <li class="list-group-item">Status : 
                          <span class="badge badge-info">`+ (product.status == 1 ? 'Publish' : 'Draft') +`</span>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              `);


          }
        })

     });
    </script>
@endsection