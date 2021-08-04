@extends('layouts.front')

@section('title','Produk')

@section('content')
<div class="container">
  <section class="py-5 bg-light">
    <div class="container">
      <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
        <div class="col-lg-6">
          <h1 class="h2 text-uppercase mb-0">Produk</h1>
        </div>
        <div class="col-lg-6 text-lg-right">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-lg-end mb-0 px-0">
              <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
              <li class="breadcrumb-item active" aria-current="page">Produk</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </section>

  <section class="py-5">
    <div class="container p-0">
      <div class="row">
        <div class="col-lg-3 order-lg-1 order-sm-1">
          <a href="{{ route('front.product') }}" class="text-dark">
            <h5 class="text-uppercase mb-4">Kategori</h5>
          </a>
            @foreach ($categories as $category)
              <div class="py-2 px-4 bg-light mb-3">
                <a href="{{ url('category/'. $category->slug) }}"  class="small text-uppercase font-weight-bold text-dark">{{ $category->name }}</a>
              </div>

              @foreach ($category->child as $child)
                <ul class="list-unstyled small text-muted pl-lg-4 font-weight-normal">
                  <li class="mb-2">
                    <a class="reset-anchor" href="{{ url('category/' . $child->slug) }}">
                      {{ $child->name }}</a>
                  </li>
                </ul>
              @endforeach
            @endforeach
              
        </div>
        <div class="col-lg-9  order-lg-2 order-sm-2 mb-5 mb-lg-0">
          <div class="row">
            @forelse ($products as $product)
              <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="product text-center">
                  <div class="position-relative mb-3">
                    <a class="d-block" href="{{ url('produk/' .$product->slug) }}">
                      <img class="img-fluid w-100" src="{{ asset("asset/produk/". $product->image) }}" alt="{{ $product->name }}">
                    </a>
                    <div class="product-overlay">
                      <ul class="mb-0 list-inline">
                        <li class="list-inline-item m-0 p-0">
                           <form action="{{ route('front.cart') }}" method="post">
                              @csrf
                              <input type="hidden" value="{{ $product->id }}" name="product_id">
                              <input type="hidden" value="1" name="qty">
                              <button class="btn btn-sm btn-dark" type="submit">Add to cart</button>
                            </form>
                        </li>
                        <li class="list-inline-item mr-0">
                          <a class="btn btn-sm btn-outline-dark DetailProduct"data-id={{ $product->id }} href="#productView" data-toggle="modal"> 
                            <i class="fas fa-expand"></i>
                          </a>
                        </li>
                      </ul> 
                    </div>
                  </div>
                  <h6>
                    <a class="reset-anchor" href="{{ url('produk/' . $product->slug) }}">{{ $product->name }}</a>
                  </h6>
                  <p class="small text-muted">Rp {{ number_format($product->price) }}</p>
                </div>
              </div>
            @empty
              <div class="col-lg-12">
                <div class="alert bg-light text-center">Tidak Ada Produk</div>
              </div>
            @endforelse
          </div>
        </div>
      </div>
    </div>
  </section>
</div>


{{-- Modal --}}
<div class="modal fade" id="productView" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body p-0">

      
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')

  <script>
    $('.DetailProduct').on('click', function(){
      const id = $(this).data('id');
      const img = "{{ asset('asset/produk/') }}";
      const cart = "{{ route('front.cart') }}";
      const token = "{{ csrf_token() }}";

      $.ajax({
        url:"{{ url('api/getProduct') }}",
        type:'GET',
        data:{ id: id},
        success:function(data){
          let product = data.product;
          let bg = img + '/' + product.image;
          
          $('.modal-body').html(`
             <div class="row align-items-stretch">
                <div class="col-lg-6 p-lg-0">
                  <a class="product-view d-block h-100 bg-cover bg-center"
                  style="background: url(`+ bg +`)" href="` + img + '/' + product.image + `" data-lightbox="productview">
                  </a>
                </div>
                <div class="col-lg-6">
                  <button class="close p-4" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                  <div class="p-5 my-md-4">
                    <h2 class="h4 modal-title">` + product.name +`</h2> 
                    <p class="text-muted">Rp `+  parseInt(product.price).toLocaleString() +`</p>
                    <p class="text-small mb-4">` + product.description +`</p>
                    <div class="row align-items-stretch mb-4">
                      <div class="col-md-12 pl-sm-0">
                        <form action="` + cart +`" method="post">
                        <input type="hidden" name="_token" value="` + token +`">
                        <input type="hidden" name="qty" value="1">
                        <input type="hidden" name="product_id" value="` + product.id +`">
                        <button class="btn btn-dark btn-sm btn-block h-100 d-flex align-items-center justify-content-center px-0" >
                          Add to cart
                        </button>
                      </div>
                    </div>
                  </div>
                </div>

              </div>

          `);
        }
      });

    })
  </script>

@endsection