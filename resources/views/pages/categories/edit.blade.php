@extends('layouts.admin.main')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Kategori Pelayanan</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.category') }}">Kategori Pelayanan</a></li>
                            <li class="breadcrumb-item active">Edit Kategori</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <form action=" {{ route('admin.category.update', ['id' => $data_category->id]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Form Tambah User</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Kode Pelayanan</label>
                                            <input name="kode_pelayanan" type="text"
                                                value="{{ $data_category->kode_pelayanan }}"
                                                class="form-control @error('kode_pelayanan')is-invalid @enderror"
                                                id="exampleInputEmail1" placeholder="Contoh: A">
                                            @error('kode_pelayanan')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Nama Pelayanan</label>
                                            <input name="nama_pelayanan" type="text"
                                                value="{{ $data_category->nama_pelayanan }}"
                                                class="form-control @error('nama_pelayanan')is-invalid @enderror"
                                                id="exampleInputEmail1" placeholder="Contoh: Customer Service">
                                            @error('nama_pelayanan')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Deskripsi</label>
                                            <textarea name="deskripsi" type="text" class="form-control @error('password')is-invalid @enderror" rows="3"
                                                placeholder="Masukkan Deskripsi">{{ $data_category->deskripsi }}</textarea>
                                            @error('password')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputFile">Icon Kategori</label>
                                            <div class="input-group">
                                                <div class="col-md-1">
                                                    @if ($data_category->image)
                                                        <img src="{{ url('icon-category/' . $data_category->image) }}"
                                                            alt="" width="100%">
                                                    @endif
                                                </div>
                                                <div class="col-md-11" style="align-content: center">
                                                    <div class="custom-file">
                                                        <input name="photo" type="file"
                                                            class="custom-file-input @error('photo')is-invalid @enderror"
                                                            id="exampleInputFile">
                                                        <label class="custom-file-label" for="exampleInputFile">Choose
                                                            File</label>
                                                        <span>
                                                            *Tambahkan file baru jika ingin mengganti foto
                                                        </span>
                                                        @error('photo')
                                                            <span class="invalid-feedback">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card -->
                        </div>
                        <!--/.col (left) -->
                    </div>
                    <!-- /.row -->
                </form>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection

@section('script')
    <!-- Get Name File -->
    <script type="application/javascript">
        $('input[type="file"]').change(function(e){
            var fileName = e.target.files[0].name;
            $('.custom-file-label').html(fileName);
        });
        </script>

    <!-- Show password -->
    <script type="application/javascript">
    $(document).ready(function() {
        $('#showPassword').change(function() {
            if ($(this).is(':checked')) {
                $('#exampleInputPassword1').attr('type', 'text');
            } else {
                $('#exampleInputPassword1').attr('type', 'password');
            }
        });
    });
    </script>
@endsection
