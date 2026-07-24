@extends('layouts.main')
@section('contentTitle')
    Laporan Keuangan
@endsection

@section('content')
<div class="container">
    <div class="mx-3 card shadow mb-4 border-left-primary">
        <div class="card-body d-flex align-items-center flex-wrap">
            <div class="mr-3">
                <h5 class="fw-bolder mb-1">Laporan Keuangan</h5>
                <small class="text-muted">Semua data di halaman ini (ringkasan, laba-rugi, dan daftar transaksi) mengikuti bulan yang dipilih di sini.</small>
            </div>
            <div class="d-flex align-items-center ml-auto mt-2 mt-md-0">
                <label for="bulan" class="mb-0 mr-2 font-weight-bold">Pilih Bulan:</label>
                <select id="bulan" name="bulan" class="custom-select custom-select-sm" style="width: auto;" aria-label="Pilih bulan laporan"></select>
            </div>
        </div>
    </div>

    <div class="mx-3 card shadow mb-4">
        <div class="card-body">
            <h6 class="fw-bolder text-uppercase text-muted mb-3" style="font-size:0.8rem;">Ringkasan Pendapatan</h6>
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        <i class="fas fa-dollar-sign mr-1"></i> Total Pendapatan
                                    </div>
                                    <div id="total-pendapatan" class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($sumMonthly, 0, ',', '.') }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        <i class="fas fa-money-bill-wave mr-1"></i> Total Cash
                                    </div>
                                    <div id="total-cash" class="h5 mb-0 font-weight-bold text-gray-800">Rp 0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-money-bill fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        <i class="fas fa-qrcode mr-1"></i> Total QRIS
                                    </div>
                                    <div id="total-qris" class="h5 mb-0 font-weight-bold text-gray-800">Rp 0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-qrcode fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        <i class="fas fa-exchange-alt mr-1"></i> Total Transfer
                                    </div>
                                    <div id="total-transfer" class="h5 mb-0 font-weight-bold text-gray-800">Rp 0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-exchange-alt fa-2x text-gray-300"></i>
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
            <div class="row">
                <div class="col-auto">
                    <h5 class="fw-bolder mb-1">Rincian Laba Rugi</h5>
                    <small class="text-muted d-block mb-3">Angka merah = pengurang laba. Kalau Laba Bersih berwarna merah, berarti rugi di bulan tersebut.</small>
                </div>
                <div class="ml-auto mr-3">
                    <a href="{{ route('biaya.index') }}" class="btn btn-primary btn-sm">Kelola Biaya Operasional</a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-borderless mb-0">
                    <tbody>
                        <tr>
                            <td>Pendapatan (Penjualan)</td>
                            <td class="text-right" id="rincian-pendapatan">Rp 0</td>
                        </tr>
                        <tr>
                            <td>HPP (Harga Pokok Penjualan)</td>
                            <td class="text-right text-danger" id="rincian-hpp">Rp 0</td>
                        </tr>
                        <tr class="border-top font-weight-bold">
                            <td>Laba Kotor</td>
                            <td class="text-right" id="rincian-laba-kotor">Rp 0 <span class="badge badge-info" id="margin-kotor">0%</span></td>
                        </tr>
                        <tr>
                            <td>Biaya Operasional</td>
                            <td class="text-right text-danger" id="rincian-biaya-operasional">Rp 0</td>
                        </tr>
                        <tr class="border-top font-weight-bold">
                            <td>Laba Operasional</td>
                            <td class="text-right" id="rincian-laba-operasional">Rp 0 <span class="badge badge-info" id="margin-operasional">0%</span></td>
                        </tr>
                        <tr>
                            <td>Biaya Non-Operasional (Pajak, Admin Bank, dll)</td>
                            <td class="text-right text-danger" id="rincian-biaya-non-operasional">Rp 0</td>
                        </tr>
                        <tr class="border-top font-weight-bold text-success">
                            <td>Laba Bersih</td>
                            <td class="text-right" id="rincian-laba-bersih">Rp 0 <span class="badge badge-success" id="margin-bersih">0%</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mx-3 card shadow mb-4">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-auto">
                    <h5 class="fw-bolder mb-0">Detail Transaksi</h5>
                </div>
                <div class="ml-auto mr-3">
                    <a href="{{ url('dashboard/export-laporan-bulanan') }}" type="button" class="btn btn-success export">Export</a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table" id="tabel-keuangan" width="100%" cellspacing="0">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Nomor Transaksi</th>
                            <th>Tanggal Transaksi</th>
                            <th>Metode Bayar</th>
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
