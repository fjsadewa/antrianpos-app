<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>POS INDONESIA | Sistem Antrian</title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="{{ asset('lte/plugins/fontawesome-free/css/all.min.css') }}">
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="{{ asset('lte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('lte/dist/css/adminlte.min.css') }}">
        <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">

        @yield('style')
    </head>

    <body class="hold-transition light-mode sidebar-mini sidebar-collapse layout-fixed layout-navbar-fixed">
        <div class="wrapper">

            <!-- Preloader -->
            <div class="preloader flex-column justify-content-center align-items-center">
                <img class="animation__wobble" src="{{ asset('gambar/Pos-Ind.png') }}" alt="PosLogo" height="100"
                    width="130">
            </div>

            <!-- Navbar -->
            @include('layouts.employee.navbar')
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            @include('layouts.employee.sidebar')

            <!-- Content Wrapper. Contains page content -->
            @yield('content')
            <!-- /.content-wrapper -->

            <!-- Main Footer -->
            @include('layouts.employee.footer')

        </div>
        <!-- ./wrapper -->

        <!-- REQUIRED SCRIPTS -->
        <!-- jQuery -->
        <script src="{{ asset('lte/plugins/jquery/jquery.min.js') }}"></script>
        <!-- Bootstrap -->
        <script src="{{ asset('lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- overlayScrollbars -->
        <script src="{{ asset('lte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('lte/dist/js/adminlte.js') }}"></script>

        <!-- PAGE PLUGINS -->
        <!-- jQuery Mapael -->
        <script src="{{ asset('lte/plugins/jquery-mousewheel/jquery.mousewheel.js') }}"></script>
        <script src="{{ asset('lte/plugins/raphael/raphael.min.js') }}"></script>
        <script src="{{ asset('lte/plugins/jquery-mapael/jquery.mapael.min.js') }}"></script>
        <script src="{{ asset('lte/plugins/jquery-mapael/maps/usa_states.min.js') }}"></script>
        <!-- ChartJS -->
        <script src="{{ asset('lte/plugins/chart.js/Chart.min.js') }}"></script>
        <!-- SweetAlert -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- Socket IO -->
        <script src="https://cdn.socket.io/4.7.5/socket.io.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

        @yield('script')

    </body>

</html>
