<!-- Topbar Navbar -->
<ul class="navbar-nav ml-auto">

    <li class="nav-item d-none d-sm-flex align-items-center mr-3">
        <span class="badge badge-success px-2 py-1 mr-2" style="font-size:0.75rem;">ADMIN</span>
        <span class="text-gray-600 font-weight-bold">{{ auth()->user()->nama ?? auth()->user()->username ?? 'Admin' }}</span>
    </li>

    <div class="topbar-divider d-none d-sm-block"></div>

    <!-- Nav Item - User Information -->
    <li class="nav-item dropdown no-arrow">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="dropdown-item" >
                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                Logout
            </button>
        </form>
    </li>

</ul>

</nav>
<!-- End of Topbar -->
