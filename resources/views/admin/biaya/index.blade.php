@extends('layouts.main')
@section('contentTitle')
    Biaya Operasional
@endsection

@section('content')
<div class="container">
    <div class="mx-3 card shadow mb-4">
        <div class="card-body">
            @include('components.alert')
            <a href="{{ route('biaya.form') }}" type="button" class="btn btn-success mb-4">Tambah Data</a>
            <div class="table-responsive">
                <table class="table" id="tabel-biaya" width="100%" cellspacing="0">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama Biaya</th>
                            <th>Kategori</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
@include('admin.biaya.script')
@endsection
