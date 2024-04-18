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
                            <li class="breadcrumb-item active"><a href="{{ route('user') }}">User</a></li>
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
                                <a href="{{ route('user.create') }}">
                                    <button class="btn bg-gradient-primary">Tambah pegawai</button>
                                </a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Nama Panggilan</th>
                                            <th>Email</th>
                                            <th>Username</th>
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
                                                <td>{{ $d->name }}</td>
                                                <td>{{ $d->email }}</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <a href="{{ route('user.edit', ['id' => $d->id]) }}">
                                                                <button type="button"
                                                                    class="btn btn-sm btn-primary btn-block"><i
                                                                        class="fa fa-pen"></i> Edit</button>
                                                            </a>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <button type="button"
                                                                class="btn btn-sm btn-danger btn-block"><i
                                                                    class="fa fa-trash"></i> hapus</button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
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
