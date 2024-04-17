<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ url('gambar/Pos-Ind.png') }}" alt="POS Logo" class="brand-image" style="opacity: .8">
        <span class="brand-text font-weight-medium">POS INDONESIA</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link ">
                        <i class="nav-icon fas fa-solid fa-clipboard"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('user') }}" class="nav-link">
                        <i class="nav-icon fas fa-solid fa-users"></i>
                        <p>
                            Petugas Loket
                        </p>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a href="{{ route('counter') }}" class="nav-link">
                        <i class="nav-icon fas fa-solid fa-store"></i>
                        <p>
                            Kategori Loket
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('history') }}" class="nav-link">
                        <i class="nav-icon fas fa-solid fa-book"></i>
                        <p>
                            Riwayat Antrian
                        </p>
                    </a>
                </li>
                <li class="nav-header">Tampilan</li>
                <li class="nav-item">
                    <a href="{{ route('display') }}" class="nav-link">
                        <i class="nav-icon fas fa-tv"></i>
                        <p>
                            Tampilan Utama
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('form') }}" class="nav-link">
                        <i class="nav-icon fas fa-columns"></i>
                        <p>
                            Tampilan Formulir
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('displaycounter') }}" class="nav-link">
                        <i class="nav-icon fas fa-desktop"></i>
                        <p>
                            Tampilan Loket
                        </p>
                    </a>
                </li>
                <li class="nav-header"> Pengaturan </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-toolbox"></i>
                        <p>
                            Pengaturan Display
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-print"></i>
                        <p>
                            Pengaturan Printer
                        </p>
                    </a>
                </li> --}}
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
