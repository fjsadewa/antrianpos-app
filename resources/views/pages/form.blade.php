@extends('layouts.display.main')

@section('content')
    <div class="container-fluid">
        <div class="row" style="justify-content: center;">
            <!-- /.Carousel-->
            <div class="col-md-7 d-flex justify-content-center">
                <div class="card" style="width: 620px">
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

            <div class="col-sm-5">
                <div class="row" style="margin-right:50px">
                    <div class="info-box" style="background-color: #EE3F22">
                        <div class="info-box-content">
                            <h2 class="info-box-text text-center" style="font-weight:bold; color:#fff!important">
                                PILIH ANTRIAN LOKET
                            </h2>
                        </div>
                    </div>
                </div>

                <div class="row d-flex justify-content-center" style="margin-right:50px">
                    <!-- Card) -->
                    @foreach ($kategoriLayanan as $kategori)
                        <div class="col-11">
                            <div class="card card-body p-3" data-kategori-id="{{ $kategori->id }}">
                                <div class="row">
                                    <div class="col-9 d-flex flex-column align-items-center justify-content-center">
                                        <h3 class="card-text" style="font-weight: bold; font-size:32px">
                                            {{ $kategori->nama_pelayanan }}</h3>
                                    </div>
                                    <div class="col-3 d-flex align-items-center justify-content-end">
                                        <i class="fas">
                                            <img src="{{ asset('storage/icon-category/' . $kategori->image) }}"
                                                alt="icon-loket" style="width: 80px; height:80px">
                                        </i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('script')
    <script type="application/javascript">
        var toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 1500
        });

        const card = document.querySelectorAll('.card');

        card.forEach(smallBox => {
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
                        // Tampilkan alert sukses
                        toast.fire({
                            icon: "success",
                            title: 'Berhasil membuat antrian',
                        })
                        displayAntrian(data.dataForm);
                        location.reload(); // Muat ulang halaman

                    } else {
                        // Tampilkan alert error
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
