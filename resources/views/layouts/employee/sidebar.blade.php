<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
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
                    <a href="{{ route('employee.dashboardEmployee', ['id' => $data->id]) }}" class="nav-link ">
                        <i class="nav-icon fas fa-solid fa-clipboard"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            Logout
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
