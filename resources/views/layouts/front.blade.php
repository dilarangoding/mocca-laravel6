<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="{{ asset('front/vendor/bootstrap/css/bootstrap.min.css')}}">
    <!-- Lightbox-->
    <link rel="stylesheet" href="{{ asset('front/vendor/lightbox2/css/lightbox.min.css')}}">
    <!-- Range slider-->
    <link rel="stylesheet" href="{{ asset('front/vendor/nouislider/nouislider.min.css')}}">
    <!-- Bootstrap select-->
    <link rel="stylesheet" href="{{ asset('front/vendor/bootstrap-select/css/bootstrap-select.min.css')}}">
    <!-- Owl Carousel-->
    <link rel="stylesheet" href="{{ asset('front/vendor/owl.carousel2/assets/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{ asset('front/vendor/owl.carousel2/assets/owl.theme.default.css')}}">
    <!-- Google fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Libre+Franklin:wght@300;400;700&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Martel+Sans:wght@300;400;800&amp;display=swap">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="{{ asset('front/css/style.default.css')}}" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="{{ asset('front/css/custom.css')}}">
    <!-- Favicon-->
    <link rel="shortcut icon" href="{{ asset('front/img/favicon.png')}}">
    @yield('css')
  </head>
  <body>
    <div class="page-holder">
      <!-- navbar-->
      <header class="header bg-white">
        <div class="container px-0 px-lg-3">
          <nav class="navbar navbar-expand-lg navbar-light py-3 px-lg-0">
            <a class="navbar-brand" href="{{ url('/') }}">
              <span class="font-weight-bold text-uppercase text-dark">Mocca</span>
            </a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            @include('layouts.front.menu')
          </nav>
        </div>
      </header>
      
    
      @yield('content')
      
      <footer class="bg-dark text-white">
        <div class="container py-4">
          <div class="row py-5">
            <div class="col-md-4 mb-3 mb-md-0">
              <h6 class="text-uppercase mb-3">Customer services</h6>
              <ul class="list-unstyled mb-0">
                <li><a class="footer-link" href="#">Help &amp; Contact Us</a></li>
                <li><a class="footer-link" href="#">Returns &amp; Refunds</a></li>
                <li><a class="footer-link" href="#">Online Stores</a></li>
                <li><a class="footer-link" href="#">Terms &amp; Conditions</a></li>
              </ul>
            </div>
            <div class="col-md-4 mb-3 mb-md-0">
              <h6 class="text-uppercase mb-3">Company</h6>
              <ul class="list-unstyled mb-0">
                <li><a class="footer-link" href="#">What We Do</a></li>
                <li><a class="footer-link" href="#">Available Services</a></li>
                <li><a class="footer-link" href="#">Latest Posts</a></li>
                <li><a class="footer-link" href="#">FAQs</a></li>
              </ul>
            </div>
            <div class="col-md-4">
              <h6 class="text-uppercase mb-3">Social media</h6>
              <ul class="list-unstyled mb-0">
                <li><a class="footer-link" href="#">Twitter</a></li>
                <li><a class="footer-link" href="https://instagram.com/riyonaryonoo">Instagram</a></li>
              </ul>
            </div>
          </div>
          <div class="border-top pt-4" style="border-color: #1d1d1d !important">
            <div class="row ">
              <div class="col-lg-12  text-center">
                <p class="small text-muted mb-0">&copy; 2021 Built With <i class="fa fa-heart text-danger"></i>  By:Riyon Aryono</p>
              </div>
            </div>
          </div>
        </div>
      </footer>
      <!-- JavaScript files-->
      <script src="{{ asset('front/vendor/jquery/jquery.min.js')}}"></script>
      <script src="{{ asset('front/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
      <script src="{{ asset('front/vendor/lightbox2/js/lightbox.min.js')}}"></script>
      <script src="{{ asset('front/vendor/nouislider/nouislider.min.js')}}"></script>
      <script src="{{ asset('front/vendor/bootstrap-select/js/bootstrap-select.min.js')}}"></script>
      <script src="{{ asset('front/vendor/owl.carousel2/owl.carousel.min.js')}}"></script>
      <script src="{{ asset('front/vendor/owl.carousel2.thumbs/owl.carousel2.thumbs.min.js')}}"></script>
      <script src="{{ asset('front/js/front.js')}}"></script>
      <!-- FontAwesome CSS - loading as last, so it doesn't block rendering-->
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
      @yield('js')
    </div>
  </body>
</html>