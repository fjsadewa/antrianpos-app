@extends('layouts.admin.main')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Setting Tampilan</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.displaysetting') }}">Setting</a></li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Video -->
                <div class="row-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header" style="display: flex; justify-content: space-between">
                            <label class="card-title" style="flex-grow: 1;">Video</label>
                            <a href="{{ route('admin.video.create') }}" style="display: inline-block;">
                                <button class="btn bg-gradient-primary">Tambah Video</button>
                            </a>
                        </div>
                        <!-- /.card-header -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- Banner-->
                <div class="row-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header" style="display: flex; justify-content: space-between">
                            <label class="card-title" style="flex-grow: 1;">Banner</label>
                            <a href="{{ route('admin.banner.create') }}" style="display: inline-block;">
                                <button class="btn bg-gradient-primary">Tambah Banner</button>
                            </a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Gambar</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($banner as $d)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td> {{ $d->judul }}</td>
                                            <td><img src="{{ url('banner/' . $d->image_banner) }}" alt=""
                                                    width="75"></td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <a href="{{ route('admin.banner.edit', ['id' => $d->id]) }}">
                                                            <button type="button"
                                                                class="btn btn-sm btn-primary btn-block"><i
                                                                    class="fa fa-pen"></i> Edit</button>
                                                        </a>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <a data-toggle="modal"
                                                            data-target="#modal-hapus{{ $d->id }}">
                                                            <button type="button"
                                                                class="btn btn-sm btn-danger btn-block"><i
                                                                    class="fa fa-trash"></i> hapus</button>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="modal-hapus{{ $d->id }}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Konfirmasi Hapus Data</h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah kamu yakin ingin menghapus Gambar
                                                            <b>{{ $d->judul }}</b> ?
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <form action="{{ route('admin.banner.delete', ['id' => $d->id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <div class="row">
                                                                <div class="col">
                                                                    <button type="button" class="btn btn-default"
                                                                        data-dismiss="modal">Batal</button>
                                                                </div>
                                                                <div class="col">
                                                                    <button type="submit"
                                                                        class="btn btn-danger">Hapus</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!-- /.modal -->
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- Footer -->
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <label class="card-title">Footer</label>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Text</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($footer as $d)
                                            <tr>
                                                <td> {{ $d->text }}</td>
                                                <td>
                                                    <div class="row">
                                                        <a href="{{ route('admin.footer.edit', ['id' => $d->id]) }}">
                                                            <button type="button"
                                                                class="btn btn-sm btn-primary btn-block"><i
                                                                    class="fa fa-pen"></i> Edit</button>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
    </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    </div>
@endsection
