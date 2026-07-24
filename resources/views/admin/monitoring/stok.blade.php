@extends('layouts.main')
@section('contentTitle')
    Monitoring Stok
@endsection

@section('content')
<div class="container">
    {{-- Summary Cards --}}
    <div class="row mx-3 mb-4">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Obat</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalObat }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-capsules fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Stok Rendah (≤10)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $obatStokRendah }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Stok Rendah --}}
    <div class="mx-3 card shadow mb-4">
        <div class="card-body">
            <h5 class="fw-bolder mb-3"><i class="fas fa-exclamation-triangle text-warning mr-2"></i>Obat dengan Stok Rendah (≤ 10)</h5>
            <div class="table-responsive">
                <table class="table" id="tabel-stok-rendah" width="100%" cellspacing="0">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama Obat</th>
                            <th>Nomor Batch</th>
                            <th>Stok Saat Ini</th>
                            <th>Tanggal Kadaluarsa</th>
                            <th>Harga Jual</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
@include('admin.monitoring.stok-script')
@endsection
