@extends('layouts.main-cashier')
@section('content')
    <div class="card o-hidden border-0 shadow-lg mt-3 mb-3">
        <div class="card-body p-5">
            <h4 class="font-weight-bold">Riwayat Pesanan</h4>
            <hr>
            <div class="row">
                <div class="col table-responsive">
                    <table class="table" id="tabel-riwayat" width="100%" cellspacing="0">
                        <thead class="text-center">
                            <tr>
                                <th>Tanggal Transaksi</th>
                                <th>Nomor Transaksi</th>
                                {{--  <th>Item</th>  --}}
                                <th>Total Pembayaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <hr>
        </div>
    </div>
@endsection
@section('script')
    @include('cashier.riwayat.script')
@endsection
