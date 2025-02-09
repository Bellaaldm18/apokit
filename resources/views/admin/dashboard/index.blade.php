@extends('layouts.main')

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
                <div class="container">
                    <canvas id="weeklyRevenueChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="mx-3 card shadow mb-4">
            <div class="card-body mt-3">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="mb-4">Obat Terlaris</h4>
                            <table class="table table-bordered">
                                <thead class="font-weight-bold">
                                    <tr>
                                        <th scope="col" class="border-left-success text-center align-middle">Nama Obat</th>
                                        <th scope="col" class="text-center">Total Penjualan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $obat)
                                        <tr class="border-left-success">
                                            <td>{{ $obat->nama_obat }}</td>
                                            <td class="text-center">{{ $obat->total_penjualan }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <h4 class="mb-4">Obat Mendekati Kadaluarsa</h4>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="border-left-danger text-center align-middle">Nama Obat</th>
                                        <th class="text-center align-middle">Tanggal Kadaluarsa</th>
                                        <th class="text-center align-middle">Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kadaluarsa as $obat)
                                        <tr class="border-left-danger">
                                            <td>{{ $obat->nama }}</td>
                                            <td>{{ $obat->tgl_kadaluarsa }}</td>
                                            <td>{{ $obat->stok }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    @include('admin.dashboard.script')
@endsection
