<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf_token" content="{{ csrf_token() }}">

    <title>Transaksi - Paledang Farma</title>

    <!-- Custom fonts for this template-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link href="{{ asset('styles/assets/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('styles/assets/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
</head>
<!-- Custom styles for this template-->
@yield('style')
<style>
    .btn-custom-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem; /* Sesuaikan ukuran font sesuai kebutuhan */
    }
</style>

<body class="bg-gray-100 ">


    <!-- Topbar Navbar -->
    <nav class="navbar navbar-expand navbar-light bg-success topbar mb-4 static-top shadow-sm">
        <span class="navbar-brand text-white font-weight-bold ml-3">
            <i class="fas fa-hospital mr-1"></i> Paledang Farma
        </span>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item font-weight-bold">
                <a href="{{ url('pesanan') }}" class="nav-link text-white">Pesanan</a>
            </li>
            <li class="nav-item font-weight-bold">
                <a href="{{ url('riwayat') }}" class="nav-link text-white">Riwayat</a>
            </li>
            <li class="nav-item d-none d-sm-flex align-items-center mx-3">
                <span class="badge badge-light px-2 py-1 mr-2" style="color:#28a745; font-size:0.75rem;">KASIR</span>
                <span class="text-white font-weight-bold">{{ auth()->user()->nama ?? auth()->user()->username ?? 'Kasir' }}</span>
            </li>
            <li class="nav-item font-weight-bold">
                <div class="nav-link">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="text-white bg-transparent border-0 fw-bold">
                            <i class="fas fa-sign-out-alt mr-1"></i> Logout
                        </button>
                    </form>
                </div>
            </li>
        </ul>
    </nav>

    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="col-12">

                @yield('content')
            </div>
        </div>
    </div>


    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('styles/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('styles/assets/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('styles/assets/js/sb-admin-2.min.js') }}"></script>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('styles/assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('styles/assets/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    @yield('script')
</body>

</html>
