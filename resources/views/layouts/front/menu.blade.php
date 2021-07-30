 <div class="collapse navbar-collapse" id="navbarSupportedContent">
  <ul class="navbar-nav mr-auto">
    <li class="nav-item">
      <a class="nav-link {{ Request::path() === '/' ? 'active' : '' }}" href="{{ url("/") }}">Beranda</a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{ Request::path() === 'produk' ? 'active' : '' }}" href="{{ route('front.product') }}">Produk Kami</a>
    </li>
  </ul>
  <ul class="navbar-nav ml-auto">               
    <li class="nav-item">
      <a class="nav-link" href="cart.html"> 
        <i class="fas fa-dolly-flatbed mr-1 text-gray"></i>
        Cart
        <small class="text-gray">(2)</small>
      </a>
    </li>
    
    <li class="nav-item">
      <a class="nav-link" href="{{ route('login') }}"> 
        <i class="fas fa-user-alt mr-1 text-gray"></i>
        Login
      </a>
    </li>
  </ul>
</div>