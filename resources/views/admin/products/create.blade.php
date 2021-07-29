@extends('layouts.admin')

@section('title', 'Tambah Produk')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Tambah Produk</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Tambah Produk </li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="container-fluid">
    <form action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">
      @csrf
      <div class="row">

        <div class="col-md-8">
          <div class="card card-outline card-dark">

            <div class="card-header">
              <h4 class="card-title">
                Tambah Produk
              </h4>
            </div>

            <div class="card-body">
              <div class="form-group">
                <label for="name">Nama Produk</label>
                <input type="text" name="name" id="name" required class="form-control @error ('name') is-invalid @enderror " value="{{ old('name') }}" >
                <p class="text-danger">{{ $errors->first('name') }}</p>
              </div>
              <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea name="description" id="description" class="form-control" required>
                  {{ old('description') }}
                </textarea>
                <p class="text-danger">{{ $errors->first('description') }}</p>
              </div>
            </div>

          </div>
        </div>

        <div class="col-md-4">
          <div class="card card-outline card-dark">
            <div class="card-body">

              <div class="form-group">
                <label for="status">status</label>
                <select class="form-control @error ('status') is-invalid @enderror"  name="status" required>
                  <option disabled selected>Pilih Status</option>
                  <option value="1" {{ old('status') == '1' ? 'selected' :'' }}>Publish</option>
                  <option value="0" {{ old('status') == '0' ? 'selected' :'' }}>Draft</option>
                </select>
                <p class="text-danger">{{ $errors->first('status') }}</p>
              </div>

              <div class="form-group">
                <label for="category_id">Kategori</label>
                <select name="category_id" id="category_id" class="form-control @error ('category_id') is-invalid @enderror">
                  <option selected disabled> Pilih Kategori</option>
                  @foreach ($category as $item)
                  <option value="{{ $item->id }}" {{ old('category_id') == $item->id ? 'selected' : '' }}>
                    {{ $item->name }}
                  </option>
                  @endforeach
                </select>
                <p class="text-danger">{{ $errors->first('category_id') }}</p>
              </div>

               <div class="form-group">
                <label for="price">Harga</label>
                <input type="text" name="price" id="price" required class="form-control @error ('price') is-invalid @enderror " value="{{ old('price') }}" >
                <p class="text-danger">{{ $errors->first('price') }}</p>
              </div>

               <div class="form-group">
                <label for="weight">Berat</label>
                <input type="text" name="weight" id="weight" required class="form-control @error ('weight') is-invalid @enderror " value="{{ old('weight') }}" >
                <p class="text-danger">{{ $errors->first('weight') }}</p>
              </div>

              
               <div class="form-group">
                <label for="image">Gambar</label>
                <input type="file" name="image" id="image" required class="form-control @error ('image') is-invalid @enderror " value="{{ old('image') }}" >
                <p class="text-danger">{{ $errors->first('image') }}</p>
              </div>
              
              <div class="form-group">  
                <button class="btn btn-block btn-dark">Simpan</button>
              </div>

            </div>
          </div>
        </div>

      </div>
    </form>
  </div>
</section>

@endsection

@section('js')

<script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
<script>
     CKEDITOR.replace('description');
</script>
@endsection