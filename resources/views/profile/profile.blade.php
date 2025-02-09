@extends('layouts.main')
@section('contentTitle')
    Edit Profil
@endsection

@section('content')
    <div class="container">
        <div class="container bg-white mx-3 p-4 rounded card shadow">
            <form action="{{ route('profile.update', ['id' => $data->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1">Nama Lengkap</label>
                            <input class="form-control" name="nama" id="exampleFormControlInput1" type="text"
                                placeholder="" value="{{ $data->nama ?? null }}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1">Nomor Telepon</label>
                            <input class="form-control" name="no_tlpn" id="exampleFormControlInput1" type="text"
                                placeholder="" value="{{ $data->no_tlpn ?? null }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1">Email</label>
                            <input class="form-control" name="email" id="exampleFormControlInput1" type="email"
                                placeholder="" value="{{ $data->email ?? null }}">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1">Username</label>
                            <input class="form-control" name="username" id="exampleFormControlInput1" type="text"
                                placeholder="" value="{{ $data->username ?? null }}" readonly>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1">Password</label>
                            <input class="form-control" name="password" id="exampleFormControlInput1" type="password"
                                placeholder="" value="">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-auto">
                        <button type="submit" class="btn btn-success mb-3">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
