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
                            <li class="breadcrumb-item active">Tambah Kategori</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <form action="{{ route('admin.category.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Formulir Tambah Kategori Pelayanan</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Kode Pelayanan</label>
                                            <input name="kode_pelayanan" type="text"
                                                class="form-control @error('kode_pelayanan')is-invalid @enderror"
                                                id="exampleInputEmail1" placeholder="Contoh: A">
                                            @error('kode_pelayanan')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Nama Pelayanan</label>
                                            <input name="nama_pelayanan" type="text"
                                                class="form-control @error('nama_pelayanan')is-invalid @enderror"
                                                id="exampleInputEmail1" placeholder="Contoh: Customer Service">
                                            @error('nama_pelayanan')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Deskripsi</label>
                                            <textarea name="deskripsi"type="text" class="form-control @error('deskripsi')is-invalid @enderror" rows="3"
                                                placeholder="Masukkan Deskripsi"></textarea>
                                            @error('deskripsi')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
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
