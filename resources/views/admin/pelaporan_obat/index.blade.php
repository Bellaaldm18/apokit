@extends('layouts.main')
@section('contentTitle')
    Informasi Obat
@endsection

@section('content')
<div class="container">
    <div class="mx-3 card shadow mb-4">
        <div class="card-body">
            <h5 class="fw-bolder mb-3">Grafik Obat Terlaris (30 Hari Terakhir)</h5>

            <div style="height: 350px;" class="d-flex justify-content-center">
                <canvas id="chartObatTerlaris"></canvas>
            </div>
            <div class="mt-3" id="legend-obat-terlaris"></div>
        </div>
    </div>

    <div class="mx-3 card shadow mb-4">
        <div class="card-body">
            <div>
                <div class="row">
                    <div class="col-auto">
                        <h5 class="mb-4 fw-bolder">Barang yang sering keluar</h5>
                    </div>
                    <div class="ml-auto mr-3">
                        <a href="{{ url('dashboard/export-laporan-obat-terlaris') }}" type="button" class="btn btn-success mb-4 export">Export</a>
                    </div>
                </div>
                <table class="table" id="tabel-obat" width="100%" cellspacing="0">
                    <thead class="text-center">
                        <tr>
                            <th class="align-middle">No</th>
                            <th class="align-middle">Nama Obat</th>
                            <th class="align-middle">Nomor Batch</th>
                            <th class="align-middle">Total Penjualan</th>
                            <th class="align-middle">Stok Saat Ini</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="mx-3 card shadow mb-4">
        <div class="card-body">
            <div>
                <div class="row">
                    <div class="col-auto">
                        <h5 class="mb-4 fw-bolder">Barang yang mendekati tanggal kadaluarsa</h5>
                    </div>
                    <div class="ml-auto mr-3">
                        <a href="{{ url('dashboard/export-laporan-obat-kadaluarsa') }}" type="button" class="btn btn-success mb-4 export">Export</a>
                    </div>
                </div>
                <table class="table" id="tabel-kadaluarsa" width="100%" cellspacing="0">
                    <thead class="text-center">
                        <tr>
                            <th class="align-middle">No</th>
                            <th class="align-middle">Nama Obat</th>
                            <th class="align-middle">Nomor Batch</th>
                            <th class="align-middle">Tanggal Kadaluarsa</th>
                            <th class="align-middle">Sisa Hari</th>
                            <th class="align-middle">Stok Saat Ini</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
@include('admin.pelaporan_obat.script')
@endsection
