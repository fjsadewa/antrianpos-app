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
@endsection

@section('script')
    <script type="application/javascript">
        const socket = io();
        var sequence = [];

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
                    method: 'POST', 
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
                        // displayAntrian(data.dataForm);   
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

        function playAudio() {
            socket.on('sequence', (receivedSequence) => {
            // Pastikan sequence yang diterima valid
                if (!validateSequenceData(receivedSequence)) {
                    console.error("Format data sequence tidak valid");
            return;
            }

            // Update sequence with the received data
            sequence = receivedSequence;

            // Inisialisasi pointer untuk melacak urutan audio
            let pointer = 0;

            function playNextAudio() {
            // Periksa apakah pointer masih dalam batas array sequence
                if (pointer < sequence.length) {
                    // Dapatkan path file audio dari sequence
                    const audioFilePath = sequence[pointer];

                    // Perbarui sumber audio dari elemen pemutar audio
                    $("#player").attr("src", "<?= asset('audio/') ?>" + audioFilePath);

                    // Putar audio
                    $("#player")[0].play();

                    // Perbarui pointer untuk audio berikutnya
                    pointer++;

                    // Panggil playNextAudio lagi setelah audio selesai diputar
                    $("#player").on('ended', playNextAudio);
                } else {
                    // Semua audio telah diputar, reset pointer
                    pointer = 0;
                }
            }

            // Mulai pemutaran audio
            playNextAudio();
            });
        }

        function validateSequenceData(sequenceData) {
            // Regex untuk memvalidasi path file audio (sama seperti di dashboard.blade.php)
            const audioFileRegex = /^([a-z0-9_-]+)\.wav$/i;

            // Periksa setiap elemen dalam array sequenceData
            for (const element of sequenceData) {
                if (!audioFileRegex.test(element)) {
                // Elemen tidak valid, tampilkan pesan error
                console.error("Format data sequence tidak valid:", element);
                return false;
                }
            }

            // Semua elemen valid, kembalikan true
            return true;
        }

    </script>
@endsection

{{--         // function playAudio(){
        //     socket.on('sequence', sequence => {
        //         sequence = audio;
        //     });

        //     changeAudio(pointer);
        // }

        // function changeAudio(seqIndex) {
        //         var audio = $("#player");
        //         var audioFile = sequence[seqIndex];
        //         var audioPath = "<?= asset('audio/') ?>/";

        //         $("#mp3_src").attr("src", audioPath + audioFile);

        //         audio[0].pause();
        //         audio[0].load(); //suspends and restores all audio element
        //         audio[0].oncanplaythrough = audio[0].play();
        // }

        //     $('#player').on('ended', function() {
        //         console.log('ended');
        //         // enable button/link
        //         if (pointer == sequence.length - 1) {
        //             pointer = 0;
        //         } else {
        //             pointer++;
        //             changeAudio(pointer);
        //         }
                
        //     }); --}}
