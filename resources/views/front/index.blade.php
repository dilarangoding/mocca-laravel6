@extends('layouts.front')

@section('title', 'Mocca.id')

@section('content')

<div class="container">
    <section class="hero pb-3 bg-cover bg-center d-flex align-items-center" style="background: url('{{ asset('front/img/hero-banner-alt.jpg') }}');">
      <div class="container py-5">
        <div class="row px-4 px-lg-5">
          <div class="col-lg-6">
            <p class="text-muted small text-uppercase mb-2">Mocca.id</p>
            <h1 class="h2 text-uppercase mb-3">Jam Tangan Lokal Terbaik</h1><a class="btn btn-dark" href="{{ route('front.product') }}">Belanja Sekarang</a>
          </div>
        </div>
      </div>
    </section>
    
    <section class="pt-5">
      <header class="text-center">
        <p class="small text-muted small text-uppercase mb-1"></p>
        <h2 class="h5 text-uppercase mb-4">Browse our categories</h2>
      </header>
      <div class="row">
        <div class="col-md-4 mb-4 mb-md-0">
          <a class="category-item" href="{{ route('front.product') }}">
            <img class="img-fluid" src="{{ asset('front/img/product-detail-1.jpg') }}" alt="">
            <strong class="category-item-title">Digital</strong>
          </a>
        </div>
        <div class="col-md-4 mb-4 mb-md-0">
          <a class="category-item " href="{{ route('front.product') }}">
            <img  width="350px" height="362px" src="{{ asset('front/img/product-9.jpg') }}" alt="">
            <strong class="category-item-title">Analog</strong>
          </a>
        </div>
        <div class="col-md-4 mb-4 mb-md-0">
          <a class="category-item " href="{{ route('front.product') }}">
            <img  width="350px" height="362px" src="{{ asset('front/img/product-detail-2.jpg') }}" alt="">
            <strong class="category-item-title">Sport</strong>
          </a>
        </div>
        
      </div>
    </section>

    <section class="pt-5">
        <header>
              <p class="small text-muted small text-uppercase mb-1">Buatan Terbaik Indonesia</p>
              <h2 class="h5 text-uppercase mb-4">Produk Jam Teratas</h2>
          </header>
    </section>

    <div class="row">
          @foreach ($products as $product)
            <div class="col-xl-3 col-lg-4 col-sm-6">
              <div class="product text-center">
                <div class="position-relative mb-3">
                  <a class="d-block" href="{{ url('produk/' . $product->slug) }}">
                    <img class="img-fluid w-100" src="{{ asset("asset/produk/". $product->image) }}" alt="{{ $product->name }}">
                  </a>
                  <div class="product-overlay">
                    <ul class="mb-0 list-inline">
                      <li class="list-inline-item m-0 p-0">
                        <a class="btn btn-sm btn-dark" href="cart.html">Add to cart</a>
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
                  <a class="reset-anchor" href="{{ url('produk/' . $product->slug) }}">
                    {{ $product->name }}
                  </a>
                </h6>
                <p class="small text-muted">Rp {{ number_format($product->price) }}</p>
              </div>
            </div>
          @endforeach
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

    </div>
    
    <section class="py-5 bg-light  mb-5">
      <div class="container">
        <div class="row text-center">
          <div class="col-lg-4 mb-3 mb-lg-0">
            <div class="d-inline-block">
              <div class="media align-items-end">
                <svg class="svg-icon svg-icon-big svg-icon-light">
                  <use xlink:href="#delivery-time-1"> </use>
                </svg>
                <div class="media-body text-left ml-3">
                  <h6 class="text-uppercase mb-1">Pengiriman Cepat</h6>
                  <p class="text-small mb-0 text-muted">Bekerjasama dengan Kurir terbaik</p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 mb-3 mb-lg-0">
            <div class="d-inline-block">
              <div class="media align-items-end">
                <svg class="svg-icon svg-icon-big svg-icon-light">
                  <use xlink:href="#helpline-24h-1"> </use>
                </svg>
                <div class="media-body text-left ml-3">
                  <h6 class="text-uppercase mb-1">Service 24 x 7 </h6>
                  <p class="text-small mb-0 text-muted">Siap sedia melayani anda</p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="d-inline-block">
              <div class="media align-items-end">
                <svg class="svg-icon svg-icon-big svg-icon-light">
                  <use xlink:href="#label-tag-1"> </use>
                </svg>
                <div class="media-body text-left ml-3">
                  <h6 class="text-uppercase mb-1">Diskon Menarik</h6>
                  <p class="text-small mb-0 text-muted">Produk dengan diskon yang menarik</p>
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
    $('.DetailProduct').on('click', function(){
      const id = $(this).data('id');
      const img = "{{ asset('asset/produk/') }}"
      const cart = "{{ url('/cart/') }}";

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
                  <a class="d-none" href="` + img + '/' + product.image + `"  data-lightbox="productview">
                  </a>
                  <a class="d-none" href="` + img + '/' + product.image + `"  data-lightbox="productview">
                  </a>
                </div>
                <div class="col-lg-6">
                  <button class="close p-4" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                  <div class="p-5 my-md-4">
                    <h2 class="h4 modal-title">` + product.name +`</h2> 
                    <p class="text-muted">Rp `+   parseInt(product.price).toLocaleString() +`</p>
                    <p class="text-small mb-4">` + product.description +`</p>
                    <div class="row align-items-stretch mb-4">
                      <div class="col-md-12 pl-sm-0">
                        <input class="form-control border-0 shadow-0 p-0" type="hidden" name="qty" value="1">
                        <a class="btn btn-dark btn-sm btn-block h-100 d-flex align-items-center justify-content-center px-0" href="` + cart +  '/' + id +`">
                          Add to cart
                        </a>
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