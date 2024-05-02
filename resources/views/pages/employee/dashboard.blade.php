@extends('layouts.employee.main')

@section('title', 'Dashboard Loket - Pos Indonesia')

@section('content')
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="container-fluid">
            <div class="row p-2">
                <div class="col-sm-3">

                    <!-- Profile Image -->
                    <div class="card">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle"
                                    src="{{ asset('storage/photo-profile/' . $data['loket']->employee->image) }}"
                                    alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center">{{ $data['loket']->employee->name }}</h3>
                            <p class="text-muted text-center">Software Engineer</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Nomor Loket</b> <a class="float-right"> {{ $data['loket']->nomor_loket }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Jenis Pelayanan</b> <a
                                        class="float-right">{{ $data['loket']->kategoriPelayanan->nama_pelayanan }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Pelayanan Hari Ini</b> <a class="float-right">-</a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- Action Box -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Action Button</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form action="{{ route('employee.callAntrian', $data['loket']->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-block btn-warning"><i
                                        class="fa fa-bell"></i> Panggil</button>
                            </form>
                            <button type="button" class="btn btn-primary btn-block btn-info"><i class="fa fa-play"></i>
                                Mulai Layani</button>
                            <button type="button" class="btn btn-primary btn-block btn-danger"><i
                                    class="fa fa-forward"></i>
                                Selanjutnya</button>
                            <button type="button" class="btn btn-primary btn-block btn-success"><i class="fa fa-check"></i>
                                Selesai</button>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-sm-9">
                    <div class="row card">
                        <div class="card-header p-2">
                            <h3 class="card-title"> Antrian Saat Ini</h3>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Kode Antrian</th>
                                        <th>Nomor Antrian</th>
                                        <th>Jenis Pelayanan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>A</td>
                                        <td>0001</td>
                                        <td>Loket</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <div class="row card">
                        <div class="card-header p-2">
                            <h3 class="card-title "> Antrian Belum Terpanggil
                                <span class="right badge badge-warning ml-2">{{ $jumlahAntrian }} Menunggu</span>
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Antrian</th>
                                        <th>Nomor Antrian</th>
                                        <th>Jenis Pelayanan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['antrian'] as $antrian)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $antrian->kategoriLayanan->kode_pelayanan }}</td>
                                            <td>{{ $antrian->nomor_urut }}</td>
                                            <td>{{ $antrian->kategoriLayanan->nama_pelayanan }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection
