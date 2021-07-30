@extends('layouts.front')

@section('title')
{{ $product->name }}
@endsection

@section('content')
    <div class="page-holder bg-light">
      <section class="py-5">
          <div class="container">
            <div class="row mb-5">
  
              <div class="col-lg-6">
                <div class="row m-sm-0 justify-content-center">
                  
                  <div class="col-sm-10 order-1 order-sm-2 ">
                    <div class="owl-carousel product-slider" data-slider-id="1">
                      <a class="d-block" href="{{ asset('asset/produk/'. $product->image) }}" data-lightbox="product" title="Product item 1">
                        <img class="img-fluid" src="{{ asset('asset/produk/'. $product->image) }}" alt="...">
                      </a>
                    </div>
                  </div>
  
                </div>
              </div>
  
              <div class="col-lg-6">
              
                <h1>{{ $product->name }}</h1>
                <p class="text-muted lead">Rp {{ number_format($product->price) }}</p>
                <p class="text-small mb-4">{!! $product->description !!}</p>
                <div class="row align-items-stretch mb-4">
                  <div class="col-sm-5 pr-sm-0">
                    <div class="border d-flex align-items-center justify-content-between py-1 px-3 bg-white border-white">
                      <span class="small text-uppercase text-gray mr-4 no-select">Quantity</span>
                      <div class="quantity">
                        <button class="dec-btn p-0"><i class="fas fa-caret-left"></i></button>
                        <input class="form-control border-0 shadow-0 p-0" type="text" name="qty" value="1">
                        <button class="inc-btn p-0"><i class="fas fa-caret-right"></i></button>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-3 pl-sm-0">
                    <a class="btn btn-dark btn-sm btn-block h-100 d-flex align-items-center justify-content-center px-0" href="#">Add to cart</a>
                  </div>
                </div>
                <br>
                <ul class="list-unstyled small d-inline-block">
                  <li class="px-3 py-2 mb-1 bg-white">
                    <strong class="text-uppercase">Berat:</strong>
                    <span class="ml-2 text-muted">{{ $product->weight }} gr</span></li>
                  <li class="px-3 py-2 mb-1 bg-white text-muted">
                    <strong class="text-uppercase text-dark">Kategori:
                    </strong><a class="reset-anchor ml-2" href="#">{{ $product->category->name }}</a>
                  </li>
                 
                </ul>
              </div>
            </div>
            <!-- DETAILS TABS-->
            <ul class="nav nav-tabs border-0" id="myTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="description-tab" data-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true">Deskripsi</a>
              </li>
            </ul>
            <div class="tab-content mb-5" id="myTabContent">
              <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                <div class="p-4 p-lg-5 bg-white">
                  <h6 class="text-uppercase">Deskripsi Produk</h6>
                  <p class="text-muted text-small mb-0">{!! $product->description !!}</p>
                </div>
              </div>
            </div>
           
            <h2 class="h5 text-uppercase mb-4">Produk Terkait</h2>
            <div class="row">
              @foreach ($related as $row)
                <div class="col-lg-3 col-sm-6">
                  <div class="product text-center skel-loader">
                    <div class="d-block mb-3 position-relative">
                      <a class="d-block" href="{{ url('produk/' . $row->slug) }}">
                        <img class="img-fluid w-100" src="{{ asset("asset/produk/". $row->image) }}" alt="{{ $row->name }}">
                      </a>
                      <div class="product-overlay">
                        <ul class="mb-0 list-inline">
                          <li class="list-inline-item m-0 p-0">
                            <a class="btn btn-sm btn-dark" href="cart.html">Add to cart</a>
                          </li>
                          <li class="list-inline-item mr-0">
                            <a class="btn btn-sm btn-outline-dark DetailProduct"data-id={{ $row->id }} href="#productView" data-toggle="modal"> 
                              <i class="fas fa-expand"></i>
                            </a>
                          </li>
                        </ul> 
                      </div>
                    </div>
                    <h6> <a class="reset-anchor" href="{{ url('produk/' . $row->slug) }}">
                      {{ $row->name }}
                    </a></h6>
                    <p class="small text-muted">Rp {{ number_format($row->price) }}</p>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
      </section>
    </div>


    {{-- modal --}}
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