@extends('layouts.admin')

@section('title','Kategori')


@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Kategori</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Kategori </li>
        </ol>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-4">
        <div class="card card-outline card-dark">
          <div class="card-header ">
            <h4 class="card-title">Tambah Kategori</h3>
          </div>
          <div class="card-body">
            <form action="{{ route('category.store') }}" method="post">
              @csrf
              <div class="form-group">
                <label for="name">Kategori</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="Kategori" name="name">
                <p class="text-danger">{{ $errors->first('name') }}</p>
              </div>
              <div class="form-group">
                <label for="parent">Parent Kategori</label>
                <select name="parent_id" id="parent" class="form-control @error('parent_id') is-invalid @enderror">
                  <option selected disabled>Pilih Kategori</option>
                  @foreach ($parent as $item)
                  <option value="{{ $item->id }}"> {{ $item->name }}</option>   
                  @endforeach
                </select>
                <p class="text-danger">{{ $errors->first('parent_id') }}</p>

              </div>
              <div class="form-group">
                <button class="btn btn-block btn-dark">Simpan</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="col-md-8">
        <div class="card card-outline card-dark">
          <div class="card-header">
            <h3 class="card-title">List Kategori</h3>
          </div>
          <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                  {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                  {{ session('error') }}
                </div>
            @endif
            <div class="table-responsive">
              <table class="table table-hover table-bordered text-center">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Kategori</th>
                    <th>Parent</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($category as $row)
                   <tr>
                     <td>{{ $loop->iteration }}</td>
                     <td>{{ $row->name }}</td>
                     <td>{{ $row->parent ? $row->parent->name : '-' }}</td>
                     <td>
                       <form action="{{ route('category.destroy', $row->id) }}" method="post">
                        @csrf
                        @method('DELETE')
            
                        <a href="#" data-toggle="modal" data-id={{ $row->id }} data-target="#exampleModal" class="btn btn-warning btn-sm editData">Edit
                        </a>
                        <button class="btn btn-danger btn-sm">Hapus</button>
                      </form>
                     </td>
                   </tr>
                  @empty
                    <tr>
                      <td colspan="4" class="text-center">Tidak ada data</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
            {!! $category->links() !!}
          </div>
        </div>
      </div>
      
    </div>
  </div>
</section>


{{-- Modal --}}
    

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Kategori</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form action="" method="post">
              @csrf
              @method('PUT')
              <div class="form-group">
                <label for="name">Kategori</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" value=""  required placeholder="Kategori" name="name" id="name">
                <p class="text-danger">{{ $errors->first('name') }}</p>
              </div>
              <div class="form-group">
                <label for="parent">Parent Kategori</label>
                <select name="parent_id" id="parent_id" class="form-control @error('parent_id') is-invalid @enderror">
                  
                </select>
                <p class="text-danger">{{ $errors->first('parent_id') }}</p>
              </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-dark" >Simpan</button>
      </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')

<script>
  
  $('.editData').on('click', function(){
       const id = $(this).data('id');
       let  url = '{{URL::to('admin/category')}}/'+id;
       $('.modal-body form').attr('action',url);
       
        $.ajax({
          url:"{{ url('/api/editCategory/') }}",
          type: "GET",
          data: { id : id},
          success: function(data){
             let category = data.category;
             $('#name').val(category.name);

             $('#parent_id').empty();
             $('#parent_id').append('<option value="" selected >Pilih Ketegori</option>')
             $.each(data.parent, function(key, item){
                $('#parent_id').append(
                `<option value=" `+ item.id +` " `+ (category.parent_id == item.id ? `selected` : `` )+`> ` + item.name +`</option>`);
             })
             
          }
        })

     });
</script>
@endsection