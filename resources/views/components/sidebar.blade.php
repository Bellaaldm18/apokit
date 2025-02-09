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
    <li class="nav-item active">
        <a class="nav-link" href="{{ url('/dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Data Master
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ url('dashboard/manajemen-obat') }}">
            <i class="fa-solid fa-capsules"></i>
            <span>Manajemen Obat</span>
        </a>
        <a class="nav-link collapsed" href="{{ url('dashboard/user') }}">
            <i class="fa-solid fa-user"></i>
            <span>Manajemen User</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Pelaporan
    </div>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{ url('dashboard/laporan-obat') }}">
            <i class="fa-solid fa-clipboard"></i>
            <span>Laporan Obat</span>
        </a>
        <a class="nav-link collapsed" href="{{ url('dashboard/laporan-keuangan') }}">
            <i class="fa-solid fa-file-invoice-dollar"></i>
            <span>Laporan Keuangan</span>
        </a>
    </li>



    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
