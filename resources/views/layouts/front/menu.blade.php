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
      <a class="nav-link" href="{{ route('front.cart_list') }}"> 
        <i class="fas fa-dolly-flatbed mr-1 text-gray"></i>
        Kerajang
        <small class="text-gray">({{ $carts }})</small>
      </a>
    </li>
    
    @if (auth()->check())
   
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="pagesDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user-alt mr-1 text-gray"></i>
           {{ auth()->user()->name }}
        </a>
        <div class="dropdown-menu mt-3" aria-labelledby="pagesDropdown">
          <a class="dropdown-item border-0 transition-link" href="{{ route('customer.dashboard') }}">Dashboard</a>
          <a class="dropdown-item border-0 transition-link"  href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Logout
          </a>
           <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
      </li>

    @else    
      <li class="nav-item">
        <a class="nav-link" href="{{ route('login') }}"> 
          <i class="fas fa-user-alt mr-1 text-gray"></i>
          Login
        </a>
      </li>
    @endif


  </ul>
</div>