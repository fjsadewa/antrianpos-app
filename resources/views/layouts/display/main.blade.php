<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>POS INDONESIA | Sistem Antrian</title>

        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="{{ asset('lte/plugins/fontawesome-free/css/all.min.css') }}">
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="{{ asset('lte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('lte/dist/css/adminlte.min.css') }}">
    </head>

    <body>
        <div class="wrapper hw-100">

            <!-- Navbar -->
            @include('layouts.display.navbar')

            <!-- Main Content -->
            <div class="content p-2" style="background-color: #1B2C5A">
                @yield('content')
            </div>
            <!-- /.content -->

            <!-- Footer -->
            @include('layouts.display.footer')

        </div>
        <!-- ./wrapper -->

        <script src="{{ asset('lte/plugins/jquery/jquery.min.js') }}"></script>
        <!-- Bootstrap -->
        <script src="{{ asset('lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- overlayScrollbars -->
        <script src="{{ asset('lte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('lte/dist/js/adminlte.js') }}"></script>
        <!-- SweetAlert -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        @yield('script')

        <!-- Showtime -->
        <script>
            $(function() {
                function updateClock() {
                    var date = new Date();
                    var dateOptions = {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    };
                    var timeOptions = {
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit',
                        hour12: false
                    };
                    var formattedDate = date.toLocaleDateString('id-ID', dateOptions);
                    var formattedTime = date.toLocaleTimeString('id-ID', timeOptions).replace("Pukul ", "").replace(
                        /\./g, ':');
                    $("#datetime").html(formattedDate + ' ' + formattedTime);
                }
                setInterval(updateClock, 1000);

                updateClock();
            });
        </script>

    </body>

</html>
