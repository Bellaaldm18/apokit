@extends('layouts.main-cashier')
@section('content')
    <div class="row">
        <div class="col-6">
            <!-- Konten Kiri -->
            <div class="card o-hidden border-0 shadow mt-3 mb-3">
                <div class="card-body p-4">
                    <h4 class="mb-3">Pilih Produk</h4>
                    <input id="search-input" class="form-control mb-3" type="text" placeholder="Cari Obat" />
                    <div class="table-responsive">
                        <table class="table" id="tabel-obat" width="100%" cellspacing="0">
                            <thead class="text-center" id="th-obat">
                                <tr>
                                    <th>Nama Obat</th>
                                    <th>Nomor Batch</th>
                                    <th>Stok</th>
                                    <th>Harga</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6">
            <!-- Konten Kanan dengan Scroll -->
            <div class="right-content-container">
                <div class="card o-hidden border-0 shadow mt-3 mb-3">
                    <div class="card-body p-4">
                        <h4 class="mb-3">Keranjang</h4>
                        <div class="table-responsive right-content-table">
                            <table class="table table-borderless" id="tabel-keranjang">
                                <thead id="th-keranjang">
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Produk</th>
                                        <th scope="col">Harga Satuan</th>
                                        <th scope="col">Kuantitas</th>
                                        <th scope="col">Total Harga</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <!-- Ringkasan Belanja -->
                        <hr>
                        <div class="row">
                            <div class="col-8">
                                <p class="pt-3 mb-0" id="total-harga-teks">Total Harga (0 Barang)</p>
                            </div>
                            <div class="col-4 text-right">
                                <p class="pt-3 mb-0"><span id="total-harga">Rp 0</span></p>
                            </div>
                        </div>
                        <hr>
                        <a class="btn btn-success btn-block" id="btn-bayar-sekarang">Bayar Sekarang</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <style>
        .right-content-container {
            max-height: calc(100vh - 50px);
            /* Sesuaikan tinggi sesuai kebutuhan */
            overflow-y: auto;
        }

        .right-content-table {
            max-height: calc(100vh - 200px);
            /* Sesuaikan tinggi sesuai kebutuhan */
            overflow-y: auto;
        }
    </style>
@endsection

@section('script')
    @include('cashier.script')
@endsection
