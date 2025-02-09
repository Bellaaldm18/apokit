@extends('layouts.main')
@section('contentTitle')
    Manajemen Obat
@endsection

@section('content')
<div class="container">
{{--  <div class="container bg-white mx-3 mb-4 p-4 rounded card shadow">  --}}
    <div class="mx-3 card shadow mb-4">
        <div class="card-body">
            <a href="{{ route('manajemen-obat.form') }}" type="button" class="btn btn-success mb-4">Tambah Data</a>
            <div class="table-responsive">
                <table class="table" id="tabel-obat" width="100%" cellspacing="0">
                    <thead class="text-center">
                        <tr>
                            <th class="align-middle">No</th>
                            <th class="align-middle">Nama Obat</th>
                            <th class="align-middle">Nomor Batch</th>
                            <th class="align-middle">Tanggal Kadaluarsa</th>
                            <th class="align-middle">Stok</th>
                            <th class="align-middle">Harga Beli</th>
                            <th class="align-middle">Harga Jual</th>
                            <th class="align-middle">Keterangan</th>
                            <th class="align-middle">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection
@section('script')
@include('admin.obat.script')
@endsection
