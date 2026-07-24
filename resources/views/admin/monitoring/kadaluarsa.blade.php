@extends('layouts.main')
@section('contentTitle')
    Monitoring Kadaluarsa
@endsection

@section('content')
<div class="container">
    {{-- Summary Cards --}}
    <div class="row mx-3 mb-4">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Mendekati Kadaluarsa (6 Bln)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $obatMendekatiKadaluarsa }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-clock fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Sudah Kadaluarsa</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $obatKadaluarsa }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-ban fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Kadaluarsa --}}
    <div class="mx-3 card shadow mb-4">
        <div class="card-body">
            <h5 class="fw-bolder mb-3"><i class="fas fa-clock text-danger mr-2"></i>Obat Mendekati / Sudah Kadaluarsa</h5>
            <div class="table-responsive">
                <table class="table" id="tabel-kadaluarsa-monitor" width="100%" cellspacing="0">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama Obat</th>
                            <th>Nomor Batch</th>
                            <th>Stok</th>
                            <th>Tanggal Kadaluarsa</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
@include('admin.monitoring.kadaluarsa-script')
@endsection
