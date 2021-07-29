<nav class="main-header navbar navbar-expand navbar-white navbar-light">

    <ul class="navbar-nav ml-auto">
     
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          admin
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
      
          <div class="dropdown-divider"></div>
         
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <!-- Message Start -->
            <div class="media">
              Logout
            </div>
            
            <!-- Message End -->
          </a>
          
        </div>
      </li>
   
    </ul>
  </nav>