@extends('layouts.admin.main')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="card ">
                    <div class="card-header" style="display: flex; justify-content: space-between">
                        <label class="card-title" style="flex-grow: 1;">Riwayat Loket</label>
                        <div style="justify-content: space-between">
                            <span>Nomor Loket</span>
                            <select name="kategori_pelayanan_id" class="custom-select rounded-2" id="id-loket">
                                @foreach ($loket as $l)
                                    <option value="{{ $l->id }}">{{ $l->nomor_loket }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="historyTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Nama Petugas</th>
                                    <th>Status Menunggu</th>
                                    <th>Status Dipanggil</th>
                                    <th>Status Dilayani</th>
                                    <th>Status Selesai</th>
                                    <th>Status Dilewati</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!-- /.card-header -->
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            var table = $('#historyTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('detailHistory') }}',
                    data: function(d) {
                        d.loket_id = $('#id-loket').val();
                    }
                },
                columns: [{data: 'tanggal'},
                    {data: 'nama_petugas'},
                    {data: 'jumlah_menunggu'},
                    {data: 'jumlah_dipanggil'},
                    {data: 'jumlah_dilayani'},
                    {data: 'jumlah_selesai'},
                    {data: 'jumlah_dilewati'},
                ]
            });

            $('#id-loket').change(function() {
                table.ajax.reload();
            });
        });
    </script>
@endsection
