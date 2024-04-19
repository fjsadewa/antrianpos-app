@extends('layouts.display.main')

@section('content')
    <div class="container-fluid">
        <div class="row" style="justify-content: space-between;">
            <!-- /.Carousel-->
            <div class="col-md-5" style="margin-left: 200px;align-content: center">
                <div class="card">
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

            <div class="col-sm-4" style="margin-right: 100px">
                <!-- Small Box (Stat card) -->
                <div class="col">
                    <button class="btn col-lg-12 mb-4 p-2" style="background-color: #EE3F22!important">
                        <h2 class="mt-2 text-center" style="font-weight:bold; color: #ffffff!important">
                            Pilih Antrian Loket
                        </h2>
                    </button>
                    <div class="col col-12">
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
                            {{-- <a class="small-box-footer"id="antrian-PENDAFTARAN" data-id-antrian="5">
                                Print <i class="fas fa-arrow-circle-right"></i>
                            </a> --}}
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
                            {{-- <a class="small-box-footer"id="antrian-informasi" data-id-antrian="21">
                                Print <i class="fas fa-arrow-circle-right"></i>
                            </a> --}}
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
                            {{-- <a class="small-box-footer"id="antrian-Online" data-id-antrian="22">
                                Print <i class="fas fa-arrow-circle-right"></i>
                            </a> --}}
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
                            {{-- <a class="small-box-footer"id="antrian-Pendataan" data-id-antrian="24">
                                Print <i class="fas fa-arrow-circle-right"></i>
                            </a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
