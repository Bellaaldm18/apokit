@extends('layouts.main-cashier')
@section('content')
    <div class="card o-hidden border-0 shadow-lg mt-3 mb-3" id="area-print">
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
                        <tr>
                            <td>Kasir</td>
                            <td class="px-2">:</td>
                            <td><strong>{{ $kasir->nama }}</strong></td>
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
                                <td colspan="4" class="pt-2"></td>
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
                            <tr class="no-print">
                                <td colspan="4"></td>
                                <td class="align-middle">
                                    <div class="d-flex justify-content-between">
                                        <span>Metode Pembayaran</span>
                                        <span>:</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <div class="form-check mr-3">
                                            <input class="form-check-input" type="radio" name="metode_ui" id="metode_cash" value="cash" checked>
                                            <label class="form-check-label" for="metode_cash">Cash</label>
                                        </div>
                                        <div class="form-check mr-3">
                                            <input class="form-check-input" type="radio" name="metode_ui" id="metode_qris" value="qris">
                                            <label class="form-check-label" for="metode_qris">QRIS</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="metode_ui" id="metode_transfer" value="transfer">
                                            <label class="form-check-label" for="metode_transfer">Transfer</label>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="metode-display">
                                <td colspan="4"></td>
                                <td>Metode Bayar</td>
                                <td><span id="metode-label" class="badge badge-info">Cash</span></td>
                            </tr>
                            <tr>
                                <td colspan="4"></td>
                                <td class="align-middle">
                                    <div class="d-flex justify-content-between">
                                        <span>Bayar</span>
                                        <span>:</span>
                                    </div>
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm w-75 m-0 bayar no-print">
                                    <span class="bayar-print d-none"></span>
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
                                <td>
                                    <span class="kembalian">Rp 0</span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4"></td>
                                <td colspan="2" class="pt-2">
                                    <small class="text-muted">Penanggung Jawab: <strong>{{ $kasir->nama }}</strong></small>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <hr>
            <div class="row no-print">
                <div class="col">
                    <form method="POST" action="{{ url('pembayaran') }}">
                        @csrf
                        <input type="hidden" name="no_pesanan" value="{{ $no_pesanan }}">
                        <input type="hidden" class="form-control form-control-sm w-75 m-0 bayar-hidden" name="bayar">
                        <input type="hidden" class="form-control form-control-sm kembalian-hidden" name="kembalian">
                        <input type="hidden" id="metode-hidden" name="metode_pembayaran" value="cash">
                        <div class="d-flex flex-row-reverse">
                            <a href="" class="btn btn-success ml-2" onclick="printReceipt()">Cetak Struk</a>
                            <button type="submit" class="btn btn-primary btn-bayar">Langsung Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('style')
<style>
    @media print {
        .no-print { display: none !important; }
        .metode-display { display: table-row !important; }
        .bayar-print { display: inline !important; }
    }
    .metode-display { display: none; }
</style>
@endsection
@section('script')
    @include('cashier.pembayaran.script')
    <script>
        $('input[name="metode_ui"]').on('change', function() {
            var val = $(this).val();
            $('#metode-hidden').val(val);
            var labels = { cash: 'Cash', qris: 'QRIS', transfer: 'Transfer' };
            $('#metode-label').text(labels[val] || 'Cash');
        });

        function printReceipt() {
            var bayarVal = $('.bayar').val();
            $('.bayar-print').text(bayarVal);

            var printButton = document.querySelector('.btn-success');
            var saveButton = document.querySelector('.btn-primary');
            if (printButton) printButton.style.display = 'none';
            if (saveButton) saveButton.style.display = 'none';

            window.print();

            if (printButton) printButton.style.display = '';
            if (saveButton) saveButton.style.display = '';
        }
    </script>
@endsection
