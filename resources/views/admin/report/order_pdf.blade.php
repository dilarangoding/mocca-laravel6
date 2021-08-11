<!DOCTYPE html>

<html>

<head>

  <title>Laporan Pesanan </title>
  

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

</head>

<body>

	<style type="text/css">

		table tr td,

		table tr th{

			font-size: 15px;

		}

		@page {

			margin: 50px 25px;

			margin-bottom: 0cm;			

		}

		.gambar{

			width: 450px;

			opacity: 0.1;

			margin-top: 240px; 

			position: relative;

		}

		.gambar1{

			max-width: 150px;

			max-height: 150px;

			margin-right: 500px;

		}

		.hasil{

			margin-top: -700px;

		}

		.custom-footer-page-number:after {

			content: counter(page) " / " counter(page);

		}

		footer {

			position: fixed; 

			bottom: 0cm; 

			left: 0cm; 

			right: 0cm;

			height: 1.3cm;

			margin-right: -25px;

			margin-left: -25px;

			font-size: 12px;



		
			line-height: 0.05cm;

		}

		.space{

			width: 80%;

		}

		#footer { 

			position: fixed; 

			width: 100%; 

			bottom: 0; 

			left: 0;

			right: 0;

		}

		.foto{

			max-height: 200px;

			margin-left: -100px;

		}

		.data{

			margin-left: 100px;

		}



		.content{

			margin-top: -50px;

		}

		.pagenum:before {

			content: counter(page);

		}

	</style>

	<header>

		<div class="row">

			<center>

				

			</center>

			<div class="col col-md-4">

				 <h1 style="color:#6772e5;"><i class="ni ni-basket"></i></h1>

			</div>

			<center>

				<div class="col col-md-4" style="font-size: 12px;">

					<p><h4>Mocca.id</h4>JL. Senada, Desa Warrior Kec. Tambun<br>Kabupaten Bekasi Jawa Barat 1832	<br>Telepon 08892388239 <br>Email : help@mocca.com 
				</div>

				<div class="col col-md-4" style="font-size: 12px;">

					<hr>

					<h5>MULAI TANGGAL {{ date('d-m-Y', strtotime($date[0])) }} SAMPAI TANGGAL {{ date('d-m-Y', strtotime($date[1])) }} </h5>

				</div>

			</center>

		</div>

	</header>


  <main>
 
       <div class="row" >
        <div class="col-md-12">
          <table class="table table-bordered text-center mt-4">
            <thead>
              <tr>
                <th>No</th>
                <th> Invoice</th>
                <th>Nama Pelanggan</th>
                <th>Subtotal</th>
                <th>Tanggal</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($order as $item)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->invoice }}</td>
                <td>{{ $item->customer_name }}</td>
                <td>Rp {{ number_format($item->subtotal) }}</td>
                <td>{{ $item->created_at->format('d-m-Y') }}</td>
              </tr>
              @empty
              <tr>
                <td colspan="5" class="text-center">Tidak ada data</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    
  </main>
 

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

</body>

</html>