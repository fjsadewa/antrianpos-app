@extends('layouts.employee.main')

@section('title', 'Dashboard Loket - Pos Indonesia')

@section('content')
    <div class="content-wrapper">
        <!-- Main content -->
        <div class="container-fluid">
            <div class="row p-2">
                <div class="col-sm-3">

                    <!-- Profile Image -->
                    <div class="card" data-loket-id="{{ $data['loket']->employee->id }}">
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
                            {{-- <form action="{{ route('employee.callAntrian', $data['loket']->id) }}" method="POST"> --}}
                            {{-- @csrf --}}
                            <input type="hidden" name="token" value="{{ csrf_token() }}" />
                            <button type="button" class="btn btn-primary btn-block btn-warning" id="btn-call"><i
                                    class="fa fa-bell"></i> Panggil</button>
                            {{-- </form> --}}
                            {{-- <button type="button" class="btn btn-primary btn-block btn-info"><i class="fa fa-play"></i>
                                Mulai Layani</button>
                            <button type="button" class="btn btn-primary btn-block btn-danger"><i
                                    class="fa fa-forward"></i>
                                Selanjutnya</button>
                            <button type="button" class="btn btn-primary btn-block btn-success"><i class="fa fa-check"></i>
                                Selesai</button> --}}
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
    <audio id="player" style="display:none;">
        <source id="mp3_src" src="" type="audio/wav">
        Your browser does not support the audio element.
    </audio>

@endsection
@section('script')
    <script>
        $(document).ready(function() {

            var pointer = 0;
            var sequence = [];

            $("#btn-call").click(function() {
                var loketId = document.querySelector('.card').dataset.loketId;

                $.ajax({
                    url: "http://localhost/laravel-10/antrianpos-app/public/employee/dashboard-employee/" +
                        loketId + "/call",
                    method: "POST",
                    data: {
                        _token: $('input[name=token]').val()
                    },
                    success: function(data) {
                        var kodeAntrian = data.data.kodeAntrian;
                        var nomorAntrian = data.data.nomorAntrian;
                        var nomorLoket = data.data.nomorLoket;

                        sequence = [
                            "bel.wav",
                            "antrian-nomor.wav"
                        ];

                        // Parse kode antrian dan nomor antrian
                        var parsedKodeAntrian = parseKodeAntrian(kodeAntrian);
                        if (parsedKodeAntrian.kodeAntrian.length > 0) {
                            for (var i in parsedKodeAntrian.kodeAntrian) {
                                sequence.push(parsedKodeAntrian.kodeAntrian[i].toLowerCase());
                            }
                        }

                        sequence.push(...parseNumberToAudioFiles(nomorAntrian));
                        sequence.push("silahkan-ke-loket.wav");
                        sequence.push(...parseNumberToAudioFiles(nomorLoket));
                        sequence.push("bel.wav");

                        console.log(sequence);

                        changeAudio(pointer);


                    }
                })
            });

            function parseKodeAntrian(kodeAntrianString) {
                var regex = /^([a-z]{1,3})$/i; // Ubah regex
                var match = kodeAntrianString.match(regex);
                if (match) {
                    var kodeAntrian = match[1].toLowerCase(); // Ubah kodeAntrian
                    var audioFile = [];
                    for (var i = 0; i < kodeAntrian.length; i++) {
                        audioFile.push(
                            "abjad/" + kodeAntrian[i] + ".wav"
                        );
                    }
                    return {
                        kodeAntrian: audioFile,
                        audioFile: audioFile
                    };
                } else {
                    return null;
                }
            }

            function parseNumberToAudioFiles(number) {
                var audioFiles = [];
                while (number > 0) {
                    var digit = number % 10;
                    audioFiles.unshift("angka/" + digit + ".wav");
                    number = Math.floor(number / 10);
                }
                return audioFiles;
            }

            function changeAudio(seqIndex) {
                var audio = $("#player");
                var audioFile = sequence[seqIndex];
                var audioPath = "<?= asset('audio/') ?>/";

                // if (audioFile.startsWith("angka/")) {
                //     audioPath += "angka/";
                // } else if (audioFile.startsWith("abjad/")) {
                //     audioPath += "abjad/";
                // }
                $("#mp3_src").attr("src", audioPath + audioFile);

                audio[0].pause();
                audio[0].load(); //suspends and restores all audio element
                audio[0].oncanplaythrough = audio[0].play();

            }

            $('#player').on('ended', function() {
                console.log('ended');
                // enable button/link
                if (pointer == sequence.length - 1) {
                    pointer = 0;
                } else {
                    pointer++;
                    changeAudio(pointer);
                }
            });
        });
    </script>
@endsection


{{-- 
    // var sequence = [
            //     'bel.wav',
            //     'antrian-nomor.wav',
            //     'abjad/a.wav',
            //     'angka/1000.wav',
            //     'angka/200.wav',
            //     'angka/30.wav',
            //     'angka/4.wav',
            //     'silahkan-ke-loket.wav',
            //     'angka/3.wav', 'bel.wav'
            // ];

                // $("#btn-call").click(function() {
            //     changeAudio(pointer);
            // });
    // $('#player').on('ended', function() {
    //     console.log('ended');
    //     // enable button/link
    //     if (pointer < sequence.length) {
    //         pointer++;
    //         changeAudio(pointer);
    //     } else {


    //     }
    // }); --}}
