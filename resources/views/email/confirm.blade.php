<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{{ asset('front/vendor/bootstrap/css/bootstrap.min.css')}}">

    <title>Konfirmasi Pesanan</title>
  </head>
  <body>
    
    <div class="container">
      <div class="row">
        <h2>Hai, {{ $order->customer_name }}</h2>
        <h3>Silahkan untuk melakukan konfirmasi pembayaran di menu pesanan atau klik <a href="{{ route('customer.order') }}">disini</a></h3>
      </div>
    </div>
    </div>
   
  </body>
</html>