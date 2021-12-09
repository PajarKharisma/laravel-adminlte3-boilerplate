<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ get_config_app()['logo'] }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ get_config_app()['title'] }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ get_avatar_path(Auth::user()) }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->id ?? null }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ url('/') }}" class="nav-link {{ $m_beranda ?? null }}">
                        <i class="nav-icon fal fa-home-lg-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                
                @if (Auth::user()->hasRole(['admin']))    
                <li class="nav-item {{ $m_admin_kelola_pengguna ?? null }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fal fa-users"></i>
                        <p>
                            Kelola Pengguna
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('admin/master-roles') }}" class="nav-link {{ $m_admin_master_roles ?? null }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Hak Akses</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('admin/master-pengguna') }}" class="nav-link {{ $m_admin_master_pengguna ?? null }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pengguna</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/admin/config-app') }}" class="nav-link {{ $m_admin_config_app ?? null }}">
                        <i class="nav-icon fal fa-cogs"></i>
                        <p>Konfigurasi</p>
                    </a>
                </li>
                @endif
                
                {{-- <li class="nav-header">MISCELLANEOUS</li> --}}
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
