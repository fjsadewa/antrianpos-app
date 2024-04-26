@extends('layouts.display.main')

@section('content')
    <div class="container-fluid">
        <div class="row" style="justify-content: center;">
            <!-- /.Carousel-->
            <div class="col-md-7 d-flex justify-content-center">
                <div class="card" style="width: 700px">
                    <div class="card-body p-1">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img class="d-flex w-100" src="{{ asset('gambar/banner.jpg') }}" alt="First slide">
                                </div>
                                <div class="carousel-item">
                                    <img class="d-flex w-100" src="{{ asset('gambar/banner.jpg') }}" alt="Second slide">
                                </div>
                                <div class="carousel-item">
                                    <img class="d-flex w-100" src="{{ asset('gambar/banner.jpg') }}" alt="Third slide">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>

            <div class="col-sm-5 ">
                <div class="row">
                    <button class="btn col-lg-12 mb-4 p-2" style="background-color: #EE3F22!important">
                        <h2 class="mt-2 text-center" style="font-weight:bold; color: #ffffff!important">
                            Pilih Antrian Loket
                        </h2>
                    </button>
                </div>

                <!-- Small Box (Stat card) -->
                <div class="row d-flex justify-content-center">
                    @foreach ($kategoriLayanan as $kategori)
                        <div class="col-md-11">
                            <div class="small-box bg-light" data-kategori-id="{{ $kategori->id }}">
                                <div class="inner">
                                    <h3>{{ $kategori->nama_pelayanan }}</h3>
                                    <p> {{ $kategori->deskripsi }}</p>
                                </div>
                                {{-- <div class="icon">
                                        <i class="fas"><img src="" alt="icon-loket"
                                                style="width: 90px; height:90px"></i>
                                    </div> --}}
                            </div>
                        </div>
                    @endforeach
                </div>


            </div>
            {{-- <div class="col col-12">
                        <!-- small card -->
                        <div class="small-box bg-light" id="pendaftaran">
                            <div class="inner">
                                <h3> LOKET</h3>
                                <p> Antrian untuk ke loket </p>
                            </div>
                            <div class="icon">
                                <i class="fas">
                                    <img src="{{ asset('gambar/Loket.png') }}" alt="icon-loket"
                                        style="width: 90px; height:90px">
                                </i>
                            </div>
                        </div>
                    </div>
                    <div class="col col-12">
                        <!-- small card -->
                        <div class="small-box bg-success" id="informasi">
                            <div class="inner">
                                <h3> Customer Service</h3>
                                <p> Antrian untuk ke pelayanan customer service</p>
                            </div>
                            <div class="icon">
                                <i class="fas">
                                    <img src="{{ asset('gambar/cs.png') }}" alt="icon-loket"
                                        style="width: 90px; height:90px">
                                </i>
                            </div>
                        </div>
                    </div>
                    <div class="col col-12">
                        <!-- small card -->
                        <div class="small-box bg-warning" id="Bansos">
                            <div class="inner">
                                <h3> Bansos</h3>
                                <p> Antrian untuk ke pelayanan loket BANSOS</p>
                            </div>
                            <div class="icon">
                                <i class="fas">
                                    <img src="{{ asset('gambar/bansos.png') }}" alt="icon-loket"
                                        style="width: 90px; height:90px">
                                </i>
                            </div>
                        </div>
                    </div>
                    <div class="col col-12">
                        <!-- small card -->
                        <div class="small-box bg-info" id="Pensiun">
                            <div class="inner">
                                <h3> Pensiun</h3>
                                <p> Antrian untuk ke pelayanan loket pensiun </p>
                            </div>
                            <div class="icon">
                                <i class="fas">
                                    <img src="{{ asset('gambar/pensiunan.png') }}" alt="icon-loket"
                                        style="width: 90px; height:90px">
                                </i>
                            </div>
                        </div>
                    </div> --}}
        </div>
    </div>
@endsection

@section('script')
    <script>
        var toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 1500
        });

        const smallBoxes = document.querySelectorAll('.small-box');

        smallBoxes.forEach(smallBox => {
            smallBox.addEventListener('click', () => {
                const kategoriId = smallBox.dataset.kategoriId;
                createAntrian(kategoriId); // Panggil fungsi createAntrian
            });
        });

        function createAntrian(kategoriId) {
            fetch(`<?= url('/createForm/${kategoriId}') ?>`, {
                    method: 'GET', // Ubah method menjadi GET
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Tambahkan header X-CSRF-TOKEN
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // alert('Antrian berhasil dibuat!'); // Tampilkan alert sukses
                        toast.fire({
                            icon: "success",
                            title: 'Berhasil membuat antrian',
                        })
                        displayAntrian(data.dataForm);
                        location.reload(); // Muat ulang halaman
                    } else {
                        // alert('Gagal membuat antrian: ' + data.message); // Tampilkan alert error
                        toast.fire({
                            icon: "failed",
                            title: 'Gagal membuat antrian: ' + data.message,
                        })
                    }
                })
                .catch(error => {
                    console.error('Error:', error); // Tampilkan error di console
                });
        }
    </script>
@endsection
