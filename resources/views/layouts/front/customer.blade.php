<div class="card bg-light">
  <div class="card-body">
    <h3 class="text-center">Menu</h3>
    <ul class="list-group list-group-flush">
      <li class="list-group-item bg-light ">
        <a href="{{ route('customer.dashboard') }}" class="{{ Request::path() === 'dashboard' ? '' : 'text-dark' }}">
          Dashboard
        </a>
      </li>
      <li class="list-group-item bg-light ">
        <a href="{{ route('customer.order') }}" class=" {{ Request::path() === 'pesanan' ? '' : 'text-dark' }} ">
          Pesanan
        </a>
      </li>
      <li class="list-group-item bg-light ">
        <a href="{{ route('customer.settingForm') }}" class="{{ Request::path() === 'setting' ? '' : 'text-dark' }} ">
          Pengaturan
        </a>
      </li>
    </ul>
  </div>
</div>