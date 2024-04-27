@extends('layouts.admin.main')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Loket</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.counter') }}">Loket</a></li>
                            <li class="breadcrumb-item active">Edit Loket</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <form action="{{ route('admin.counter.update', ['id' => $data_counter->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Formulir Edit Loket</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Nomor Loket</label>
                                            <input name="nomor_loket" type="text"
                                                class="form-control @error('nomor_loket')is-invalid @enderror"
                                                id="exampleInputEmail1" value="{{ $data_counter->nomor_loket }}"
                                                placeholder="Contoh: 8">
                                            @error('nomor_loket')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleSelectRounded0">Jenis Pelayanan</label>
                                            <select name="kategori_pelayanan_id" class="custom-select rounded-2"
                                                id="exampleSelectRounded0">
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ $data_counter->kategoriPelayanan->id == $category->id ? 'selected' : '' }}>
                                                        {{ $category->nama_pelayanan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleSelectRounded0">Status</label>
                                            <select name="status" required class="custom-select rounded-2"
                                                id="exampleSelectRounded0">
                                                <option value="terbuka" @selected(old('status') === 'terbuka')>Buka</option>
                                                <option value="tertutup" @selected(old('status') === 'tertutup')>Tutup</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleSelectRounded0">Nama Petugas</label>
                                            <select name="user_id"
                                                class="custom-select rounded-2 @error('user_id')is-invalid @enderror"
                                                id="exampleSelectRounded0">
                                                @foreach ($user as $employee)
                                                    <option value="{{ $employee->id }}"
                                                        {{ $data_counter->employee->user_id == $employee->id ? 'selected' : '' }}>
                                                        {{ $employee->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('user_id')
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
