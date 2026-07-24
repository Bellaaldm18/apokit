@extends('layouts.main')
@section('contentTitle')
    Manajemen User
@endsection

@section('content')
<div class="container">
    <div class="mx-3 card shadow mb-4">
        <div class="card-body">
        <form action="{{ route('user.store', ['id' => $data->id ?? null]) }}" method="POST">
            @csrf
            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="role">Role</label>
                        <select name="role" id="role" class="form-control custom-select @error('role') is-invalid @enderror" data-placeholder="Pilih Role">
                            <option value="" selected></option>
                            <option value="admin" {{ old('role', $data->role ?? null) == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="kasir" {{ old('role', $data->role ?? null) == 'kasir' ? 'selected' : '' }}>Kasir</option>
                        </select>
                        @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="mb-3">
                        <label for="nama">Nama Lengkap</label>
                        <input class="form-control @error('nama') is-invalid @enderror" name="nama" id="nama" type="text" placeholder="" value="{{ old('nama', $data->nama ?? null) }}">
                        @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label for="no_tlpn">Nomor Telepon</label>
                        <input class="form-control" name="no_tlpn" id="no_tlpn" type="text" placeholder="" value="{{ old('no_tlpn', $data->no_tlpn ?? null) }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <div class="mb-3">
                        <label for="email">Email</label>
                        <input class="form-control" name="email" id="email" type="email" placeholder="" value="{{ old('email', $data->email ?? null) }}">
                    </div>
                </div>
                <div class="col-4">
                    <div class="mb-3">
                        <label for="username">Username</label>
                        <input class="form-control @error('username') is-invalid @enderror" name="username" id="username" type="text" placeholder="" value="{{ old('username', $data->username ?? null) }}">
                        @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-4">
                    <div class="mb-3">
                        <label for="password">Password</label>
                        <input class="form-control @error('password') is-invalid @enderror" name="password" id="password" type="password" placeholder="{{ isset($data) ? 'Kosongkan jika tidak ingin ubah password' : '' }}" value="">
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-auto">
                    <button type="submit" class="btn btn-success mb-3">Simpan</button>
                    <a href="{{ url('dashboard/user') }}" class="btn btn-secondary mb-3 ml-2">Batal</a>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>
@endsection
