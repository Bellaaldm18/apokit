@extends('layouts.main-cashier')
@section('content')
    <div class="card o-hidden border-0 shadow-lg mt-3 mb-3">
        <!-- Header Struk -->
<div class="text-center mb-4">
    <img src="{{ asset('logo-apotek.png') }}"
         alt="Logo Apotek"
         width="100">

    <h4 class="mt-2 mb-0 font-weight-bold">APOTEK PALEDANG FARMA</h4>
    <p class="mb-0">
        Jl. Paledang No.34, RT.05/RW.07, Bogor Tengah<br>
        Kota Bogor, Jawa Barat<br>
    </p>
    <hr>
</div>
    <div class="card-body p-4">
            <h4 class="font-weight-bold">Detail Pesanan</h4>
            <hr>
            <div class="row pb-4">
                <div class="col-6">
                    <table>
                        <tr>
                            <td>No Pesanan</td>
                            <td class="px-2">:</td>
                            <td>{{ $data->no_transaksi }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Pesanan</td>
                            <td class="px-2">:</td>
                            <td>{{ \Carbon\Carbon::parse($data->tgl_transaksi)->locale('id')->translatedFormat('j F Y') }}</td>
                        </tr>
                        <tr>
                            <td>Kasir</td>
                            <td class="px-2">:</td>
                            <td><strong>{{ $data->kasir->nama ?? '-' }}</strong></td>
                        </tr>
                        <tr>
                            <td>Metode Pembayaran</td>
                            <td class="px-2">:</td>
                            <td>{{ strtoupper($data->metode_pembayaran ?? '-') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col table-responsive">
                    <table class="table table-borderless" id="tabel-detail">
                        <thead class="border-bottom font-weight-bold">
                            <tr>
                                <td>No</td>
                                <td>Nama Obat</td>
                                <td>Nomor Batch Obat</td>
                                <td>Harga Satuan</td>
                                <td>Kuantitas</td>
                                <td>Total Harga</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $total_barang = 0;
                            @endphp
                            @foreach ($data->detailTransaksis as $index => $item)
                            <tr>
                                <td>{{ $index+1 }}</td>
                                <td>{{ $item->obat->nama }}</td>
                                <td>{{ $item->obat->no_batch }}</td>
                                <td>Rp {{ number_format($item->obat->harga_jual, 0, ',', '.') }}</td>
                                <td>{{ $item->kuantitas }}</td>
                                <td>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                            </tr>

                            @php
                                $total_barang += $item->kuantitas;
                            @endphp
                            @endforeach
                        </tbody>
                        <tfoot class="table-sm border-top py-2">
                            <tr class="pt-2">
                                <td colspan="4" class="pt-2"></td>
                                <td>
                                    <div class="d-flex justify-content-between">
                                        <span>Total Barang</span>
                                        <span>:</span>
                                    </div>
                                </td>
                                <td class="total-barang">{{ $total_barang }}</td>
                            </tr>
                            <tr>
                                <td colspan="4"></td>
                                <td>
                                    <div class="d-flex justify-content-between">
                                        <span>Total Pembayaran</span>
                                        <span>:</span>
                                    </div>
                                </td>
                                <td class="text-lg text-success font-weight-bold total-pembayaran">Rp {{ number_format($data->total_pembayaran, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td colspan="4"></td>
                                <td>
                                    <div class="d-flex justify-content-between">
                                        <span>Bayar</span>
                                        <span>:</span>
                                    </div>
                                </td>
                                <td class="text-lg text-info font-weight-bold total-pembayaran">Rp {{ number_format($data->bayar, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td colspan="4"></td>
                                <td>
                                    <div class="d-flex justify-content-between">
                                        <span>Kembalian</span>
                                        <span>:</span>
                                    </div>
                                </td>
                                <td class="text-lg text-danger font-weight-bold total-pembayaran">Rp {{ number_format($data->kembalian, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <hr>
            <div class="row no-print">
                <div class="col">
                    <div class="d-flex flex-row-reverse">
                        <button type="button" class="btn btn-success ml-2" onclick="printReceipt()">Cetak Struk</button>
                        <a href="{{ url('riwayat') }}" class="btn btn-secondary ml-2">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('style')
<style>
    @media print {
        .no-print { display: none !important; }
    }
</style>
@endsection
@section('script')
    @include('cashier.riwayat.script')
    <script>
        function printReceipt() {
            // Sembunyikan tombol cetak sebelum mencetak
            var printButton = document.querySelector('.btn-success');
            if (printButton) {
                printButton.style.display = 'none';
            }

            // Panggil dialog cetak
            window.print();

            // Tampilkan kembali tombol cetak setelah mencetak
            if (printButton) {
                printButton.style.display = 'block';
            }
        }
    </script>

@endsection
