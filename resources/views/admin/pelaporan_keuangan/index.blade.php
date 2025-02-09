@extends('layouts.main')
@section('contentTitle')
    Laporan Keuangan
@endsection

@section('content')
<div class="container">
{{--  <div class="container bg-white mx-3 mb-4 p-4 rounded card shadow">  --}}
    <div class="mx-3 card shadow mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Pendapatan Hari Ini
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($sumToday, 0, ',', '.') }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Pendapatan Minggu Ini
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($sumWeekly, 0, ',', '.') }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Pendapatan Bulan Ini
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($sumMonthly, 0, ',', '.') }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="mx-3 card shadow mb-4">
        <div class="card-body">
            <div class="mb-3">
                <div class="row">
                    <div class="col-auto align-center">
                        <label for="bulan" class="">Pilih Bulan:</label>
                    </div>
                    <div class="col-4 align-center">
                        <select id="bulan" name="bulan" class="custom-select custom-select-sm" aria-label="Default select example"></select>
                    </div>
                    <div class="ml-auto mr-3">
                        <a href="{{ url('dashboard/export-laporan-bulanan') }}" type="button" class="btn btn-success mb-4 export">Export</a>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table" id="tabel-keuangan" width="100%" cellspacing="0">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Nomor Transaksi</th>
                            <th>Tanggal Transaksi</th>
                            <th>Total Transaksi</th>
                        </tr>
                    </thead>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection
@section('script')
@include('admin.pelaporan_keuangan.script')
@endsection
