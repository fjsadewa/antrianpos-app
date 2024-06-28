@extends('layouts.employee.main')

@section('title', 'Riwayat Loket - Pos Indonesia')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3> Nomor Loket {{ $data['loket']->nomor_loket }}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="historyTable" class="table table-bordered table-striped user-history">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Jumlah Dipanggil</th>
                                            <th>Jumlah Selesai</th>
                                            <th>Jumlah Dilewati</th>
                                        </tr>
                                    </thead>
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
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#historyTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('userHistory') }}',
                columns: [{
                        data: 'tanggal'
                    },
                    {
                        data: 'jumlah_dipanggil'
                    },
                    {
                        data: 'jumlah_selesai'
                    },
                    {
                        data: 'jumlah_dilewati'
                    },
                ]
            });
        });
    </script>
@endsection
