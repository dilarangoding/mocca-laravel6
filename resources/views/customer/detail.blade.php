<div class="container">

  <div class="row">
    <div class="col-md-6">
      <h4>Data Pelanggan</h4>
      <table class="table table-borderless">
        <tr>
          <td width="40%">Invoice</td>
          <td width="1%">:</td>
          <th>{{ $order->invoice }}</th>
        </tr>
        <tr>
          <td>Nama Penerima</td>
          <td>:</td>
          <th>{{ $order->customer_name }}</th>
        </tr>
        <tr>
          <td>No Telpn</td>
          <td>:</td>
          <th>{{ $order->customer_phone }}</th>
        </tr>
        <tr>
          <td>Alamat</td>
          <td>:</td>
          <th>{{ $order->customer_address }}, {{ $order->district->name }},
            {{ $order->district->city->type }} {{ $order->district->city->name }},
             {{ $order->district->city->province->name }}
          </th>
        </tr>
      </table>
    </div>
    <div class="col-md-6">
      <h4>Data Pembayaran</h4>
      @if ($order->status == 0)
       <div class="alert alert-danger">
        <a href="{{ url('/payment?invoice=' . $order->invoice) }}" class="text-dark">Konfirmasi pembayaran disini</a>
       </div>    
      @endif

      @if ($order->payment)
        <table class="table table-borderless">
          <tr>
            <td width="40%">Nama Pengirim</td>
            <td width="1%">:</td>
            <th>{{ $order->payment->name }}</th>
          </tr>
          <tr>
            <td>Tanggal Transfer</td>
            <td>:</td>
            <th>{{ $order->payment->transfer_date}}</th>
          </tr>
          <tr>
            <td>Jumlah Transfer</td>
            <td>:</td>
            <th>Rp {{ number_format($order->payment->amount) }}</th>
          </tr>
          <tr>
            <td>Tujuan Transfer</td>
            <td>:</td>
            <th>{{ $order->payment->transfer_to }}</th>
          </tr>
          <tr>
            <td>Bukti Transfer</td>
            <td>:</td>
            <th>
              <a href="{{ asset('asset/payment/' . $order->payment->proof) }}" target="_blank">
                Lihat detail
              </a>
            </th>
          </tr>
        </table>
      @endif
    </div>
  </div>
  
  <div class="row">
    <div class="col-md-12">
      <div class="table-responsive">
        <table class="table table-bordered text-center">
          <thead>
            <tr>
              <th>Nama Produk</th>
              <th>Kuantitas</th>
              <th>Harga</th>
              <th>Subtotal</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($order->orderDetail as $item)
            <tr>
              <td>{{ $item->product->name }}</td>
              <td>{{ $item->qty }}</td>
              <td>Rp {{ number_format($item->price) }}</td>
              <td>Rp {{ number_format($item->price * $item->qty) }}</td>
            </tr>   
            @endforeach
          </tbody>
          <tfoot>
            <tr class="bg-light">
              <td colspan="3 ">Total</td>
              <td>Rp {{ number_format($order->subtotal) }}</td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>

</div>