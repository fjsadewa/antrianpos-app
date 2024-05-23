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
                            <input type="hidden" name="token" value="{{ csrf_token() }}" />
                            <button type="button" class="btn btn-primary btn-block btn-warning" id="btn-call"><i
                                    class="fa fa-bell"></i> Panggil</button>
                            {{-- <button type="button" class="btn btn-primary btn-block btn-info"><i class="fa fa-play"></i>
                                Mulai Pelayanan</button>
                            <button type="button" class="btn btn-primary btn-block btn-success"><i class="fa fa-check"></i>
                                Selesai</button>
                                --}}
                            {{-- <button type="button" class="btn btn-primary btn-block btn-danger"><i
                                    class="fa fa-forward"></i>
                                Selanjutnya</button> --}}
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
    {{-- <audio id="player" style="display:none;">
        <source id="mp3_src" src="" type="audio/wav">
        Your browser does not support the audio element.
    </audio> --}}

@endsection
@section('script')
    <script>
        $(document).ready(function() {
            var pointer = 0;
            var sequence = [];
            var onQueue = null;
            var loketId = document.querySelector('.card').dataset.loketId;
            updateQueue(loketId);

            function updateQueue($loketId) {
                $.ajax({
                    url: "http://localhost/laravel-10/antrianpos-app/public/employee/dashboard-employee/" +
                        loketId + "/getAntrian",
                    method: "GET",
                    success: function(data) {
                        if (data.data) {
                            onQueue = data.data;
                            console.log(onQueue);
                            $("#btn-call").prop("disabled", false);
                        } else {
                            onQueue = null;
                            console.log(onQueue);
                            $("#btn-call").prop("disabled", true);
                        }
                    }
                });
            }

            function updateSequenceSuara(kodeAntrian, nomorAntrian, nomorLoket) {
                if (onQueue) {
                    sequence = [
                        "bel.wav",
                        "antrian-nomor.wav"
                    ];

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

                } else {
                    sequence = [];
                }
            }

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

            function procesTens(number, audioFiles) {
                var tensDigit = Math.floor(number / 10) % 10;
                var unitsDigit = number % 10;

                if (tensDigit === 1 && unitsDigit >= 1 && unitsDigit <= 9) {
                    audioFiles.push("angka/" + (tensDigit * 10 + unitsDigit) + ".wav");
                } else if (tensDigit >= 2 && unitsDigit === 0) {
                    audioFiles.push("angka/" + tensDigit + "0.wav");
                } else if (tensDigit >= 2 && unitsDigit >= 1 && unitsDigit <= 9) {
                    audioFiles.push("angka/" + tensDigit + "0.wav");
                    audioFiles.push("angka/" + unitsDigit + ".wav");
                } else if (tensDigit === 0 && unitsDigit > 0) {
                    audioFiles.push("angka/" + unitsDigit + ".wav");
                }
            }

            function parseNumberToAudioFiles(number) {
                var audioFiles = [];

                var numDigits = 0;
                var tempNumber = number;
                while (tempNumber > 0) {
                    numDigits++;
                    tempNumber = Math.floor(tempNumber / 10);
                }

                switch (numDigits) {
                    case 1:
                        audioFiles.push("angka/" + (number % 10) + ".wav");
                        break;

                    case 2:
                        procesTens(number, audioFiles);
                        break;

                    case 3:
                        var hundredsDigit = Math.floor(number / 100) % 10;
                        var tensDigit = Math.floor(number / 10) % 10;
                        var unitsDigit = number % 10;

                        if (hundredsDigit === 1 && tensDigit === 0 && unitsDigit === 0) {
                            audioFiles.push("angka/100.wav");
                            break;
                        }

                        if (hundredsDigit > 0) {
                            audioFiles.push("angka/" + hundredsDigit + "00.wav");
                        }
                        procesTens(number, audioFiles);
                        break;

                    case 4:
                        var thousandsDigit = Math.floor(number / 1000) % 10;
                        var hundredsDigit = Math.floor(number / 100) % 10;

                        if (thousandsDigit === 1 && hundredsDigit === 0 && tensDigit === 0 && unitsDigit === 0) {
                            audioFiles.push("angka/1000.wav");
                            break;
                        }

                        if (thousandsDigit > 0) {
                            audioFiles.push("angka/" + thousandsDigit + "000.wav");
                        }

                        if (hundredsDigit > 0) {
                            audioFiles.push("angka/" + hundredsDigit + "00.wav");
                        }
                        procesTens(number, audioFiles);
                        break;
                }
                return audioFiles;
            }

            $("#btn-call").click(function() {
                if (onQueue) {

                    var token = $('input[name=token]').val();
                    $.ajax({
                        url: "http://localhost/laravel-10/antrianpos-app/public/employee/dashboard-employee/" +
                            loketId + "/updateAntrian",
                        method: "POST",
                        data: {
                            _token: token
                        },
                        success: function(data) {
                            if (onQueue) {
                                var kodeAntrian = onQueue.kodeAntrian;
                                var nomorAntrian = onQueue.nomorAntrian;
                                var nomorLoket = onQueue.nomorLoket;

                                console.log(onQueue);
                                updateSequenceSuara(kodeAntrian, nomorAntrian, nomorLoket);
                                $.ajax({
                                    url: "http://localhost:3000/call",
                                    data: {
                                        sequence: sequence
                                    },
                                    success: function(data) {},
                                    error: function(error) {
                                        console.error(error);
                                    }
                                });
                            } else {
                                console.error("Failed to update queue status:", data.message);
                            }

                        },
                        error: function(error) {
                            console.error("Error sending POST request:", error);
                        }
                    });


                    // Simpan flag untuk menandakan sequence suara telah diputar
                    localStorage.setItem("sequenceDiputar", true);
                }
            });

        });
    </script>
@endsection


{{-- 
    // const socket = io();
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

            // if (audioFile.startsWith("angka/")) {
                //     audioPath += "angka/";
                // } else if (audioFile.startsWith("abjad/")) {
                //     audioPath += "abjad/";
                // }
                
    // $('#player').on('ended', function() {
    //     console.log('ended');
    //     // enable button/link
    //     if (pointer < sequence.length) {
    //         pointer++;
    //         changeAudio(pointer);
    //     } else {

        function parseNumberToAudioFiles(number) {
                var audioFiles = [];
                while (number > 0) {
                    var digit = number % 10;
                    audioFiles.unshift("angka/" + digit + ".wav");
                    number = Math.floor(number / 10);
                }
                return audioFiles;
            }

// if (!validateSequenceData(sequence)) {
                        //     console.error("Invalid sequence data format");
                        //     return;
                        // }

                        // socket.emit('sequence', sequence);
    //     }
    // }); 
    
    
            // function validateSequenceData(sequenceData) {
            //     // Regex untuk memvalidasi path file audio
            //     const audioFileRegex = /^([a-z0-9_-]+)\.wav$/i;

            //     // Periksa setiap elemen dalam array sequenceData
            //     for (const element of sequenceData) {
            //         if (!audioFileRegex.test(element)) {
            //             // Elemen tidak valid, tampilkan pesan error
            //             console.error("Format data sequence tidak valid:", element);
            //             return false;
            //         }
            //     }

            //     // Semua elemen valid, kembalikan true
            //     return true;
            // }
            
            --}}
