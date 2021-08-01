@extends('layouts.front')

@section('title','Keranjang Belanja')

@section('content')

<div class="container">

  <section class="py-5 bg-light">
    <div class="container">
      <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
        <div class="col-lg-6">
          <h1 class="h2 text-uppercase mb-0">Keranjang</h1>
        </div>
        <div class="col-lg-6 text-lg-right">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-lg-end mb-0 px-0">
              <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
              <li class="breadcrumb-item active" aria-current="page">Kerajang</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </section>

  <section class="py-5">

    @if (session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>   
    @endif

    @if (session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>   
    @endif

    <h2 class="h5 text-uppercase mb-4">Keranjang Belanja</h2>
    <form action="{{ route('front.update_cart') }}" method="post">
      @csrf
      @method('PUT')
      <div class="row">
        <div class="col-lg-8 mb-4 mb-lg-0">
          <!-- CART TABLE-->
          <div class="table-responsive mb-4">
            <table class="table ">
              <thead class="bg-light ">
                <tr>
                  <th class="border-0" scope="col">
                    <strong class="text-small text-uppercase">Produk</strong>
                  </th>
                  <th class="border-0" scope="col"> 
                    <strong class="text-small text-uppercase">Harga</strong>
                  </th>
                  <th class="border-0" scope="col"> 
                    <strong class="text-small text-uppercase">Kuantitas</strong>
                  </th>
                  <th class="border-0" scope="col"> 
                    <strong class="text-small text-uppercase">Total</strong>
                  </th>
                  <th class="border-0" scope="col">
                  </th>
                </tr>
              </thead>
              <tbody>
              @forelse ($carts as $item)
                <tr>
                  <th class="pl-0 border-0" scope="row">
                    <div class="media align-items-center">
                      <a class="reset-anchor d-block animsition-link"
                        href="{{ url('produk', $item['product_slug']) }}">
                        <img src="{{ asset('asset/produk/' .$item['product_image']) }}" alt="{{ $item['product_name'] }}" width="70" />
                      </a>
                      <div class="media-body ml-3">
                        <strong class="h6">
                          <a class="reset-anchor animsition-link" href="{{ url('produk', $item['product_slug']) }}">
                            {{ $item['product_name'] }}
                          </a>
                        </strong>
                      </div>
                    </div>
                  </th>
                  <td class="align-middle border-0">
                    <p class="mb-0 small">Rp {{ number_format($item['product_price'] )}}</p>
                  </td>
                  <td class="align-middle border-0">
                    <div class="border d-flex align-items-center justify-content-between px-3">
                      <span class="small text-uppercase text-gray headings-font-family">Kuantitas</span>
                      <div class="quantity">
                        <a class="dec-btn p-0">
                          <i class="fas fa-caret-left"></i>
                        </a>
                        <input class="form-control form-control-sm border-0 shadow-0 p-0" type="text" value="{{ $item['qty'] }}" name="qty[]"   />
                        <a class="inc-btn p-0">
                          <i class="fas fa-caret-right"></i>
                        </a>
                      </div>
                      <input type="hidden" value="{{ $item['product_id'] }}" name="product_id[]">
                    </div>
                  </td>
                  <td class="align-middle border-0">
                    <p class="mb-0 small">Rp {{ number_format($item['product_price'] * $item['qty']) }}</p>
                  </td>
                  <td class="align-middle border-0">
                    <a class="reset-anchor" href="{{ route('front.delete_cart', $item['product_id']) }}">
                      <i class="fas fa-trash-alt small text-muted"></i>
                    </a>
                    
                  </td>
                </tr> 
              @empty
              <tr>
                <td colspan="4" class="text-center">Keranjang Anda Kosong Yuk Segera Belanja</td>
              </tr>
              @endforelse
            </tbody>
            </table>
          </div>
    
          <div class="bg-light px-4 py-3">
            <div class="row align-items-center text-center">
              <div class="col-md-6 mb-3 mb-md-0 text-md-left">
                  <button class="btn btn-dark">Update Keranjang</button>
              </div>
              <div class="col-md-6 text-md-right">
                <a class="btn btn-outline-dark btn-sm" href="{{ route('front.product') }}">
                  <i class="fas fa-long-arrow-alt-left mr-2"></i>
                  Lanjut Belanja
                </a>

              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="card border-0 rounded-0 p-lg-4 bg-light">
            <div class="card-body">
              <h5 class="text-uppercase mb-4">Total</h5>
              <ul class="list-unstyled mb-0">
                <li class="d-flex align-items-center justify-content-between">
                  <strong class="text-uppercase small font-weight-bold">Subtotal</strong>
                  <span class="text-muted small">Rp {{ number_format($subtotal) }}</span>
                </li>
                <li class="border-bottom my-2"></li>
                <li class="d-flex align-items-center justify-content-between mb-4">
                  <strong class="text-uppercase small font-weight-bold">Total</strong>
                  <span><b>Rp {{ number_format($subtotal) }}</b></span></li>
                <li>
                @if ($carts != NULL)
                  <a class="btn btn-outline-dark btn-block btn-sm" href="{{ route("front.checkout") }}">
                      Checkout Sekarang
                      <i class="fas fa-long-arrow-alt-right ml-2"></i>
                  </a>
                @else
                  
                @endif
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </form>
  </section>

</div>

@endsection