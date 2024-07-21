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
                                <div class="card-body text-center">
                                    <p>Data pada bulan ini kosong.</p>
                                    <img src="https://via.placeholder.com/150" alt="No Data" class="img-fluid">
                                </div>
                            </div>
                        @else
                            <!-- Info Boxes -->
                            <div class="row">
                                @foreach ($kategoriTransaksi as $kategori)
                                    <div class="col-12">
                                        <div class="info-box mb-3">
                                            <span class="info-box-icon bg-primary elevation-1"><i
                                                    class="fas fa-tags"></i></span>
                                            <div class="info-box-content">
                                                <span
                                                    class="info-box-text">{{ $kategori->kategoriLayanan->nama_pelayanan }}</span>
                                                <span class="info-box-number">{{ $kategori->total }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
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
