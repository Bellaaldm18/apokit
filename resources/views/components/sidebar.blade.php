<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-success sidebar text-gray-900 sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon">
            <i class="fa-solid fa-hospital"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Paledang Farma</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">Data Master</div>

    <li class="nav-item {{ request()->is('dashboard/manajemen-obat*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{ url('dashboard/manajemen-obat') }}">
            <i class="fa-solid fa-capsules"></i>
            <span>Manajemen Obat</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">Monitoring</div>

    <li class="nav-item {{ request()->is('dashboard/monitoring*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{ url('dashboard/monitoring') }}">
            <i class="fa-solid fa-chart-line"></i>
            <span>Stok & Kadaluarsa</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">Pelaporan</div>

    <li class="nav-item {{ request()->is('dashboard/laporan-obat*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{ url('dashboard/laporan-obat') }}">
            <i class="fa-solid fa-clipboard"></i>
            <span>Laporan Obat</span>
        </a>
    </li>
    <li class="nav-item {{ request()->is('dashboard/laporan-keuangan*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{ url('dashboard/laporan-keuangan') }}">
            <i class="fa-solid fa-clipboard"></i>
            <span>Laporan Keuangan</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">Pengaturan</div>

    <li class="nav-item {{ request()->is('dashboard/user*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="{{ url('dashboard/user') }}">
            <i class="fa-solid fa-user"></i>
            <span>Manajemen User</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->

</ul>
<!-- End of Sidebar -->
