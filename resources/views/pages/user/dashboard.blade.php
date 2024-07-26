@extends('layouts.admin.main')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <section class="content">
            <div class="container-fluid">
                <div class="row d-flex align-items-center">
                    <div class="form-group mr-2">
                        <label for="nomor_ip">IP Server</label>
                        <input type="text" class="form-control" id="nomor_ip" name="nomor_ip"
                            value="{{ $ip_address }}" readonly>
                    </div>
                    <button type="button" class="btn btn-primary mt-2" data-toggle="modal" data-target="#editIPModal">
                        Edit IP
                    </button>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="editIPModal" tabindex="-1" role="dialog" aria-labelledby="editIPModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editIPModalLabel">Edit IP</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="editIPForm" action="{{ route('admin.update.ip') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="nomor_ip_modal">IP Server</label>
                                        <input type="text" class="form-control" id="nomor_ip_modal" name="nomor_ip"
                                            value="{{ $ip_address == '-' ? '' : $ip_address }}">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" form="editIPForm">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- Left col -->
                    <div class="col-md-8">
                        <!-- solid sales graph -->
                        <div class="card bg-white">
                            <div class="card-header border-0">

                                <h2 class="card-title">
                                    <i class="fas fa-book mr-1"></i>
                                    <b> Rekap Antrian </b>
                                </h2>
                                <div class="card-tools ">
                                    <form method="GET" action="{{ route('admin.dashboard') }}" class="form-inline">
                                        <div class="form-group mr-2">
                                            <label for="month">Month:</label>
                                            <select name="month" id="month" class="form-control ml-1">
                                                @for ($i = 1; $i <= 12; $i++)
                                                    <option value="{{ $i }}"
                                                        {{ $i == $selectedMonth ? 'selected' : '' }}>{{ $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="form-group mr-2">
                                            <label for="year">Year:</label>
                                            <select name="year" id="year" class="form-control ml-1">
                                                @for ($i = date('Y'); $i >= date('Y') - 10; $i--)
                                                    <option value="{{ $i }}"
                                                        {{ $i == $selectedYear ? 'selected' : '' }}>{{ $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                    </form>
                                </div>
                            </div>
                            <div class="card-body">
                                <canvas class="chart" id="salesGraph"
                                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer bg-transparent">
                                <div class="row">
                                    <div class="col-3 text-center">
                                        <h5>Menunggu: {{ $counts->menunggu }}</h5>
                                    </div>
                                    <div class="col-3 text-center">
                                        <h5>Terpanggil: {{ $counts->terpanggil }}</h5>
                                    </div>
                                    <!-- ./col -->
                                    <div class="col-3 text-center">
                                        <h5>Terlayani: {{ $counts->terlayani }}</h5>
                                    </div>
                                    <!-- ./col -->
                                    <div class="col-3 text-center">
                                        <h5>Terlewati: {{ $counts->terlewati }}</h5>
                                    </div>
                                    <!-- ./col -->
                                </div>
                                <!-- /.row -->
                            </div>
                            <!-- /.card-footer -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->

                    <div class="col-md-4">
                        @if ($kategoriTransaksi->isEmpty())
                            <div class="card">
                                <div class="card-header border-0">
                                    <h3 class="card-title">Kategori</h3>
                                </div>
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-striped table-valign-middle">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <td>-</td>
                                            <td>-</td>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @else
                            <!-- Info Boxes -->
                            <div class="card">
                                <div class="card-header border-0">
                                    <h3 class="card-title">Kategori</h3>
                                </div>
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-striped table-valign-middle">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($kategoriTransaksi as $kategori)
                                                <tr>
                                                    <td>
                                                        {{ $kategori->kategoriLayanan->nama_pelayanan }}
                                                    </td>
                                                    <td>{{ $kategori->total }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                    </div>
                    @endif
                </div>
                <!-- /.col -->
            </div>
    </div>
    </section>
    </div>
@endsection

@section('script')
    <script>
        const ctx = document.getElementById('salesGraph').getContext('2d');
        const graphData = @json($graphData);

        // const labels = graphData.map(data => data.date);
        const labels = graphData.map(data => {
            const date = new Date(data.date);
            return date.getDate();
        });
        const data = graphData.map(data => data.count);

        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Antrian',
                    data: data,
                    backgroundColor: 'rgba(0, 123, 255, 0.5)',
                    borderColor: 'rgba(0, 123, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
