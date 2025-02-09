@extends('layouts.main')
@section('contentTitle')
    Manajemen User
@endsection

@section('content')
    <div class="container bg-white mx-3 p-4 rounded card shadow">
        <form action="{{ route('user.store', ['id' => request('id')]) }}" method="POST">
            @csrf
            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1">Role</label>
                        <select name="role" id="role" class="form-control custom-select" data-placeholder="Pilih Role">
                            <option value=""selected></option>
                            <option value="admin" {{ ($data->role ?? null) == null ?  null : (($data && $data->role == 'admin') ? 'selected' : '') }}>Admin</option>
                            <option value="kasir" {{ ($data->role ?? null) == null ?  null : (($data && $data->role == 'kasir') ? 'selected' : '') }}>Kasir</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1">Nama Lengkap</label>
                        <input class="form-control" name="nama" id="exampleFormControlInput1" type="text" placeholder="" value="{{ $data->nama ?? null }}">
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1">Nomor Telepon</label>
                        <input class="form-control" name="no_tlpn" id="exampleFormControlInput1" type="text" placeholder="" value="{{ $data->no_tlpn ?? null }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1">Email</label>
                        <input class="form-control" name="email" id="exampleFormControlInput1" type="email" placeholder="" value="{{ $data->email ?? null }}">
                    </div>
                </div>
                <div class="col-4">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1">Username</label>
                        <input class="form-control" name="username" id="exampleFormControlInput1" type="text" placeholder="" value="{{ $data->username ?? null }}">
                    </div>
                </div>
                <div class="col-4">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1">Password</label>
                        <input class="form-control" name="password" id="exampleFormControlInput1" type="password" placeholder="" value="">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-auto">
                    <button type="submit" class="btn btn-success mb-3">Simpan</button>
                </div>
            </div>
            {{--  <div class="mb-3">
        <label for="exampleFormControlSelect1">Example select</label><select class="form-control" id="exampleFormControlSelect1">
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="exampleFormControlSelect2">Example multiple select</label><select class="form-control" id="exampleFormControlSelect2" multiple="">
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
        </select>
    </div>  --}}

        </form>
    </div>
@endsection
