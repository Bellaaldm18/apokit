@extends('layouts.main')
@section('contentTitle')
    Manajemen User
@endsection

@section('content')
<div class="container">
{{--  <div class="container bg-white mx-3 mb-4 p-4 rounded card shadow">  --}}
    <div class="mx-3 card shadow mb-4">
        <div class="card-body">
            <a href="{{ route('user.form') }}" type="button" class="btn btn-success mb-4">Tambah Data</a>
            <div class="table-responsive">
                <table class="table" id="tabel-user" width="100%" cellspacing="0">
                    <thead class="">
                        <tr>
                            <th class="align-middle">No</th>
                            <th class="align-middle">Role</th>
                            <th class="align-middle">Nama Lengkap</th>
                            <th class="align-middle">Email</th>
                            <th class="align-middle">Nomor Telepon</th>
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
@include('admin.user.script')
@endsection
