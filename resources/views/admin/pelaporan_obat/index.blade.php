@extends('layouts.main')
@section('contentTitle')
    Informasi Obat
@endsection

@section('content')
<div class="container">
{{--  <div class="container bg-white mx-3 mb-4 p-4 rounded card shadow">  --}}
    <div class="mx-3 card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <div class="row">
                    <div class="col-auto">
                        <h5 class="mb-4 fw-bolder">Barang yang sering keluar</h5>
                    </div>
                    <div class="ml-auto mr-3">
                        <a href="{{ url('dashboard/export-laporan-obat-terlaris') }}" type="button" class="btn btn-success mb-4 export">Export Data</a>
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
            <div class="table-responsive">
                <div class="row">
                    <div class="col-auto">
                        <h5 class="mb-4 fw-bolder">Barang yang mendekati tanggal kadaluarsa</h5>
                    </div>
                    <div class="ml-auto mr-3">
                        <a href="{{ url('dashboard/export-laporan-obat-kadaluarsa') }}" type="button" class="btn btn-success mb-4 export">Export Data</a>
                    </div>
                </div>
                <table class="table" id="tabel-kadaluarsa" width="100%" cellspacing="0">
                    <thead class="text-center">
                        <tr>
                            <th class="align-middle">Nama Obat</th>
                            <th class="align-middle">Nomor Batch</th>
                            <th class="align-middle">Tanggal Kadaluarsa</th>
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
