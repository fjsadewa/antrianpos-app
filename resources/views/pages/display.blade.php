@extends('layouts.display.main')

@section('content')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body pt-1 pl-1 pr-1 pb-0">
                        <iframe width="100%" height="460px"
                            src="https://www.youtube.com/embed/UrM8J9NoFjw?autoplay=1&loop=1&controls=0&mute=1"
                            title="Atta Halilintar | PosAja! Wujudkan Keceriaan" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen></iframe>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->

            <div class="col-lg-4 col-md-12 text-center">
                <div class="card">
                    <div class="card-header mt-2 mb-1">
                        <h3 class="card-title" style="font-weight: bold; font-size:28px;">
                            Nomor Antrian
                        </h3>
                    </div>
                    <!-- /.card-header -->

                    <div class="card-body">
                        <br>
                        <h3 style="font-weight: bold; font-size:80px;">
                            A - 0001
                        </h3>
                        <br>
                        <h3 style="font-weight: bold; font-size:42px;">
                            Customer Service
                        </h3>
                    </div>

                    <div class="dropdown-divider"></div>

                    <div class="col-12 d-flex align-items-stretch flex-column">
                        <div class="card d-flex flex-fill pt-3" style="background-color: #EE3F22!important ">
                            <div class="card-body pt-0 mb-0">
                                <div class="row">
                                    <div class="col-7" style="justify-content: center; align-content:center">
                                        <h2 class="lead" style="font-weight: bold; font-size:30px; color:#fff">
                                            Nicole Pearson
                                        </h2>
                                    </div>
                                    <div class="col-5 text-center">
                                        <img src="{{ asset('lte/dist/img/user1-128x128.jpg') }}" alt="user-avatar"
                                            class="img-circle img-fluid" style="width: 80px; height: 80px">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row text-center pt-2 pb-2">
            @foreach ($antrian as $antrians)
                <div class="col-lg-3 ">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title" style="font-weight: bold; font-size:28px;">
                                Nomor Antrian
                            </h3>
                        </div>
                        <div class="card-body">
                            <br>
                            <h3 style="font-weight: bold; font-size:50px;">
                                {{ $antrians->kategoriLayanan->kode_pelayanan }} -
                                {{ formatNomorUrut($antrians->nomor_urut_terendah) }}
                            </h3>
                            <br>
                        </div>
                    </div>
                </div>
            @endforeach
            {{-- <div class="col-lg-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" style="font-weight: bold; font-size:28px;">
                            Nomor Antrian
                        </h3>
                    </div>
                    <div class="card-body">
                        <br>
                        <h3 style="font-weight: bold; font-size:50px;">A - 0001</h3>
                        <br>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" style="font-weight: bold; font-size:28px;">
                            Nomor Antrian
                        </h3>
                    </div>
                    <div class="card-body">
                        <br>
                        <h3 style="font-weight: bold; font-size:50px;">A - 0001</h3>
                        <br>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title" style="font-weight: bold; font-size:28px;">
                            Nomor Antrian
                        </h3>
                    </div>
                    <div class="card-body">
                        <br>
                        <h3 style="font-weight: bold; font-size:50px;">A - 0001</h3>
                        <br>
                    </div>
                </div>
            </div> --}}
        </div>

        <!-- /.card-body -->
    </div>

    @php
        function formatNomorUrut($nomor)
        {
            return str_pad($nomor, 4, '0', STR_PAD_LEFT);
        }
    @endphp
@endsection
