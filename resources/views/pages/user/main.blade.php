@extends('layouts.admin.main')

@section('title', 'Daftar Petugas Loket')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Daftar Pengguna</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active"><a href="{{ route('admin.user') }}">User</a></li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-header">
                                <a href="{{ route('admin.user.create') }}">
                                    <button class="btn bg-gradient-primary">Tambah pegawai</button>
                                </a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Photo</th>
                                            <th>Nama Panggilan</th>
                                            <th>Email</th>
                                            <th>Nomer Loket</th>
                                            <th>Jenis Pelayanan</th>
                                            <th>Role</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $d)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td><img src="{{ asset('storage/photo-profile/' . $d->image) }}"
                                                        alt="" width="50"></td>
                                                <td>{{ $d->name }}</td>
                                                <td>{{ $d->email }}</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <a href="{{ route('admin.user.edit', ['id' => $d->id]) }}">
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
                                                            <p>Apakah kamu yakin ingin menghapus data
                                                                <b>{{ $d->name }}</b> ?
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <form
                                                                action="{{ route('admin.user.delete', ['id' => $d->id]) }}"
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
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>


@endsection
