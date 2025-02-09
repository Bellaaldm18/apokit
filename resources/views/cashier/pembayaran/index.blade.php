@extends('layouts.main-cashier')
@section('content')
    <div class="card o-hidden border-0 shadow-lg mt-3 mb-3">
        <div class="card-body p-5">
            <h4 class="font-weight-bold">Detail Pesanan</h4>
            <hr>
            <div class="row pb-4">
                <div class="col-6">
                    <table>
                        <tr>
                            <td>No Pesanan</td>
                            <td class="px-2">:</td>
                            <td>{{ $no_pesanan }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal Pesanan</td>
                            <td class="px-2">:</td>
                            <td>{{ now()->format('j F Y') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col table-responsive">
                    <table class="table table-borderless" id="tabel-keranjang">
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

                        </tbody>
                        <tfoot class="table-sm border-top py-2">
                            <tr class="pt-2">
                                <td colspan="4" class="pt-2"</td>
                                <td>
                                    <div class="d-flex justify-content-between">
                                        <span>Total Barang</span>
                                        <span>:</span>
                                    </div>
                                </td>
                                <td class="total-barang"></td>
                            </tr>
                            <tr>
                                <td colspan="4"></td>
                                <td>
                                    <div class="d-flex justify-content-between">
                                        <span>Total Pembayaran</span>
                                        <span>:</span>
                                    </div>
                                </td>
                                <td class="text-lg text-success font-weight-bold total-pembayaran"></td>
                            </tr>
                            <tr>
                                <td colspan="4"></td>
                                <td class="align-middle">
                                    <div class="d-flex justify-content-between">
                                        <span>Bayar</span>
                                        <span>:</span>
                                    </div>
                                </td>
                                <td class="">
                                    <input type="text" class="form-control form-control-sm w-75 m-0 bayar">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4"></td>
                                <td class="align-middle">
                                    <div class="d-flex justify-content-between">
                                        <span>Kembalian</span>
                                        <span>:</span>
                                    </div>
                                </td>
                                <td class="">
                                    <span class="kembalian">Rp 0</span>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col">
                    <form method="POST" action="{{ url('pembayaran') }}">
                        @csrf
                        <input type="hidden" name="no_pesanan" value="{{ $no_pesanan }}">
                        <input type="hidden" class="form-control form-control-sm w-75 m-0 bayar-hidden" name="bayar">
                        <div class="d-flex flex-row-reverse">
                            <a href="" class="btn btn-success ml-2">Cetak Struk</a>
                            <button type="submit" class="btn btn-primary btn-bayar">Langsung Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    @include('cashier.pembayaran.script')
@endsection
