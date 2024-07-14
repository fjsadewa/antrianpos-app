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
                                <img class="img-fluid" style="width: 100%; max-width:200px; height:auto; border-radius:10%;"
                                    src="{{ url('photo-profile/' . $data['loket']->employee->image) }}"
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
                                    <b>Pelayanan Hari Ini</b><a class="float-right">{{ $jumlahPelayanan }}</a>
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
                            <button type="button" class="btn btn-block btn-warning" id="btn-call"><i
                                    class="fa fa-bell"></i> Panggil</button>
                            <button type="button" class="btn btn-primary btn-block btn-info" id="btn-start"><i
                                    class="fa fa-play"></i> Mulai Pelayanan</button>
                            <button type="button" class="btn btn-primary btn-block btn-success" id="btn-finish"><i
                                    class="fa fa-check"></i> Selesai</button>
                            <button type="button" class="btn btn-block btn-danger" id="btn-skip" data-toggle="modal"
                                data-target="#modal-skip"><i class="fa fa-forward"></i> Selanjutnya</button>
                        </div>
                        <!-- /.card-body -->

                        <div class="modal fade" id="modal-skip">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Konfirmasi Lewati Antrian</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p id="modal-text"></p>
                                    </div>
                                    <div class="modal-footer d-flex justify-content-end">
                                        <div class="row">
                                            <div class="col">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Batal</button>
                                            </div>
                                            <div class="col">
                                                <button type="button" id="btn-next" class="btn btn-danger">Yakin</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
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

                            <table id="example1" class="table table-bordered table-striped antrian-sekarang-table">
                                <thead>
                                    <tr>
                                        <th>Kode Antrian</th>
                                        <th>Nomor Antrian</th>
                                        <th>Jenis Pelayanan</th>
                                    </tr>
                                </thead>
                                <tbody>

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
                            <table id="example1" class="table table-bordered table-striped antrian-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Antrian</th>
                                        <th>Nomor Antrian</th>
                                        <th>Jenis Pelayanan</th>
                                    </tr>
                                </thead>
                                <tbody>
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
            var isQueueCalled = false;
            var isQueueStart = false;
            const timeoutInterval = 60000;
            var toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 1500,
            });
            var antrianSekarangTable = $('.antrian-sekarang-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('datatable/antrianSekarangData') }}",
                columnDefs: [{
                    targets: 0,
                    searchable: false,
                    render: function(data, type, row, meta) {
                        return data.kategori_layanan.kode_pelayanan;
                    },
                }, {
                    targets: 2,
                    searchable: false,
                    render: function(data, type, row, meta) {
                        return data.kategori_layanan.nama_pelayanan;
                    },
                }],
                columns: [{
                        data: null,
                        name: 'kode_antrian'
                    },
                    {
                        data: 'nomor_urut',
                        name: 'nomor_antrian'
                    },
                    {
                        data: null,
                        name: 'jenis_pelayanan'
                    }
                ]
            });
            var antrianTable = $('.antrian-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('datatable/antrianData') }}",
                columnDefs: [{
                    targets: 1,
                    searchable: false,
                    render: function(data, type, row, meta) {
                        return data.kategori_layanan.kode_pelayanan;
                    },
                }, {
                    targets: 3,
                    searchable: false,
                    render: function(data, type, row, meta) {
                        return data.kategori_layanan.nama_pelayanan;
                    },
                }],
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: null,
                        name: 'kode_antrian'
                    },
                    {
                        data: 'nomor_urut',
                        name: 'nomor_antrian'
                    },
                    {
                        data: null,
                        name: 'jenis_pelayanan'
                    }
                ]
            });
            var loketId = document.querySelector('.card').dataset.loketId;
            getQueue(loketId);
            // setTimeout(() => {
            //     window.location.reload();
            // }, timeoutInterval);
            function getQueue($loketId) {
                $.ajax({
                    url: "{{ url('employee/dashboard-employee') }}/" +
                        loketId + "/getAntrian",
                    method: "GET",
                    success: function(data) {
                        if (data.data) {
                            onQueue = data.data;
                            console.log(onQueue);
                            var kodeAntrian = onQueue.kodeAntrian;
                            var nomorAntrian = onQueue.nomorAntrian;
                            var nomorLoket = onQueue.nomorLoket;

                            $('#modal-text').text('Apakah kamu yakin ingin melewati nomor antrian ' +
                                kodeAntrian + ' - ' + nomorAntrian + '?');
                            if (onQueue.status_antrian === "dipanggil") {
                                isQueueCalled = true;
                                console.log("Queue is called:", isQueueCalled);
                            } else if (onQueue.status_antrian === "dilayani") {
                                isQueueStart = true;
                                console.log("Queue is start:", isQueueStart);
                            } else {
                                isQueueCalled = false;
                                console.log("Queue is not called:", isQueueCalled);
                            }
                            // Update button states based on queue status
                            if (isQueueCalled) {
                                $("#btn-call").prop("disabled", false);
                                $("#btn-skip").prop("disabled", false);
                                $("#btn-start").prop("disabled", false);
                                $("#btn-finish").prop("disabled", true);
                            } else if (isQueueStart) {
                                $("#btn-call").prop("disabled", true);
                                $("#btn-skip").prop("disabled", true);
                                $("#btn-start").prop("disabled", true);
                                $("#btn-finish").prop("disabled", false);
                            } else {
                                $("#btn-call").prop("disabled", false);
                                $("#btn-skip").prop("disabled", true);
                                $("#btn-start").prop("disabled", true);
                                $("#btn-finish").prop("disabled", true);
                            }
                        } else {
                            onQueue = null;
                            console.log(onQueue);
                            $("#btn-call").prop("disabled", true);
                            $("#btn-skip").prop("disabled", true);
                            $("#btn-start").prop("disabled", true);
                            $("#btn-finish").prop("disabled", true);
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
                    $.ajax({
                        url: "http://192.168.5.160:3000/call",
                        //url: "http://localhost:3000/call",
                        data: {
                            sequence: sequence
                        },
                        success: function(data) {
                            console.log("Sequence sound updated and sent to 192.168.5.160:3000", data);
                        },
                        error: function(error) {
                            console.error("Error sending sequence data to 192.168.5.160:3000", error);
                        }
                    });
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

            function showAntrian(kodeAntrian, nomorAntrian, nomorLoket, namaPetugas, namaPelayanan, photo) {
                list = [
                    kodeAntrian, nomorAntrian, nomorLoket, namaPetugas,
                    namaPelayanan, photo
                ];
                console.log(list);
                $.ajax({
                    //url: "http://localhost:3000/show",
                    url: "http://192.168.5.160:3000/show",
                    data: {
                        list: list
                    },
                    success: function(data) {
                        console.log(
                            "Data sent to 192.168.5.160:3000",
                            data);
                    },
                    error: function(error) {
                        console.error(
                            "Error sent data to 192.168.5.160:3000",
                            error);
                    }
                });
            }
            $("#btn-call").click(function() {
                if (onQueue) {
                    if (isQueueCalled) {
                        var kodeAntrian = onQueue.kodeAntrian;
                        var nomorAntrian = onQueue.nomorAntrian;
                        var nomorLoket = onQueue.nomorLoket;
                        var namaPetugas = onQueue.namaPetugas;
                        var namaPelayanan = onQueue.namaPelayanan;
                        var photo = onQueue.photo;
                        updateSequenceSuara(kodeAntrian, nomorAntrian, nomorLoket);
                        showAntrian(kodeAntrian, nomorAntrian, nomorLoket,
                            namaPetugas, namaPelayanan, photo);
                        toast.fire({
                            icon: "success",
                            title: "Berhasil melakukan panggilan",
                        });
                    } else {
                        var token = $('input[name=token]').val();
                        $.ajax({
                            url: "{{ url('employee/dashboard-employee') }}/" +
                                loketId + "/panggilAntrian",
                            method: "POST",
                            data: {
                                _token: token
                            },
                            success: function(data) {
                                if (onQueue) {
                                    var kodeAntrian = onQueue.kodeAntrian;
                                    var nomorAntrian = onQueue.nomorAntrian;
                                    var nomorLoket = onQueue.nomorLoket;
                                    var namaPetugas = onQueue.namaPetugas;
                                    var namaPelayanan = onQueue.namaPelayanan;
                                    var photo = onQueue.photo;
                                    updateSequenceSuara(kodeAntrian, nomorAntrian, nomorLoket);
                                    showAntrian(kodeAntrian, nomorAntrian, nomorLoket,
                                        namaPetugas, namaPelayanan, photo);
                                    isQueueCalled = true;
                                    $("#btn-skip").prop("disabled", false);
                                    $("#btn-start").prop("disabled", false);
                                    toast.fire({
                                        icon: "success",
                                        title: "Berhasil melakukan panggilan",
                                    });
                                    // window.location.reload();
                                    antrianSekarangTable.ajax.reload();
                                    antrianTable.ajax.reload();
                                } else {
                                    console.error("Failed to update queue status:", data
                                        .message);
                                }
                            },
                            error: function(error) {
                                console.error("Error sending POST request:", error);
                            }
                        });
                    }
                    localStorage.setItem("sequenceDiputar", true);
                }
            });
            $("#btn-start").click(function() {
                if (isQueueCalled && onQueue) {
                    var token = $('input[name=token]').val();
                    $.ajax({
                        url: "{{ url('employee/dashboard-employee') }}/" +
                            loketId +
                            "/mulaiAntrian",
                        method: "POST",
                        data: {
                            _token: token,
                            antrianId: onQueue.id
                        },
                        success: function(data) {
                            $("#btn-call").prop("disabled", true);
                            $("#btn-skip").prop("disabled", true);
                            $("#btn-start").prop("disabled", true);
                            $("#btn-finish").prop("disabled", false);
                            isQueueStart = true;
                            toast.fire({
                                icon: "success",
                                title: "Mulai Pelayanan",
                            });
                        },
                        error: function(error) {
                            console.error("Error sending POST request:", error);
                        }
                    });
                }
            });
            $("#btn-finish").click(function() {
                if (isQueueStart && onQueue) {
                    var token = $('input[name=token]').val();
                    $.ajax({
                        url: "{{ url('employee/dashboard-employee') }}/" +
                            loketId +
                            "/selesai",
                        method: "POST",
                        data: {
                            _token: token,
                            antrianId: onQueue.id
                        },
                        success: function(data) {
                            onQueue = null;
                            $("#btn-call").prop("disabled", false);
                            $("#btn-skip").prop("disabled", true);
                            $("#btn-start").prop("disabled", true);
                            $("#btn-finish").prop("disabled", true);
                            isQueueCalled = false;
                            isQueueStart = false;
                            getQueue(loketId);
                            console.log(onQueue);
                            antrianSekarangTable.ajax.reload();
                            antrianTable.ajax.reload();
                            toast.fire({
                                icon: "success",
                                title: "Selesai! Lanjutkan untuk antrian selanjutnya",
                            });
                        },
                        error: function(error) {
                            console.error("Error sending POST request:", error);
                        }
                    });
                }
            });
            $("#btn-next").click(function() {
                if (isQueueCalled && onQueue) {
                    var token = $('input[name=token]').val();
                    $.ajax({
                        url: "{{ url('employee/dashboard-employee') }}/" +
                            loketId +
                            "/lewatiAntrian",
                        method: "POST",
                        data: {
                            _token: token,
                            antrianId: onQueue.id
                        },
                        success: function(data) {
                            onQueue = null;
                            $("#btn-call").prop("disabled", true);
                            $("#btn-skip").prop("disabled", true);
                            $("#btn-start").prop("disabled", true);
                            alert("Antrian telah dilewati.");
                            isQueueCalled = false;
                            getQueue(loketId);
                            console.log(onQueue);
                            $('#modal-skip').modal('hide');
                            // window.location.reload();
                            antrianSekarangTable.ajax.reload();
                            antrianTable.ajax.reload();
                        },
                        error: function(error) {
                            console.error("Error sending POST request:", error);
                        }
                    });
                }
            });
        });
    </script>
@endsection
{{--  
// const socket = io();
// var sequence = [
// 'bel.wav',
// 'antrian-nomor.wav',
// 'abjad/a.wav',
// 'angka/1000.wav',
// 'angka/200.wav',
// 'angka/30.wav',
// 'angka/4.wav',
// 'silahkan-ke-loket.wav',
// 'angka/3.wav', 'bel.wav'
// ];

// $("#btn-call").click(function() {
// changeAudio(pointer);
// });

// if (audioFile.startsWith("angka/")) {
// audioPath += "angka/";
// } else if (audioFile.startsWith("abjad/")) {
// audioPath += "abjad/";
// }

// $('#player').on('ended', function() {
// console.log('ended');
// // enable button/link
// if (pointer < sequence.length) { // pointer++; // changeAudio(pointer); // } else { // function
    //parseNumberToAudioFiles(number) { // var audioFiles=[]; // while (number> 0) {
    // var digit = number % 10;
    // audioFiles.unshift("angka/" + digit + ".wav");
    // number = Math.floor(number / 10);
    // }
    // return audioFiles;
    // }

    // if (!validateSequenceData(sequence)) {
    // console.error("Invalid sequence data format");
    // return;
    // }

    // socket.emit('sequence', sequence);
    // }
    // });


    // function validateSequenceData(sequenceData) {
    // // Regex untuk memvalidasi path file audio
    // const audioFileRegex = /^([a-z0-9_-]+)\.wav$/i;

    // // Periksa setiap elemen dalam array sequenceData
    // for (const element of sequenceData) {
    // if (!audioFileRegex.test(element)) {
    // // Elemen tidak valid, tampilkan pesan error
    // console.error("Format data sequence tidak valid:", element);
    // return false;
    // }
    // }

    // // Semua elemen valid, kembalikan true
    // return true;
    // } --}}
