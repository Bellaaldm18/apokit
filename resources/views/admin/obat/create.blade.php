@extends('layouts.main')
@section('contentTitle')
    Manajemen Obat
@endsection

@section('content')
    <div class="container bg-white mx-3 p-4 rounded card shadow">
        <form action="{{ route('manajemen-obat.store', ['id' => request('id')]) }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-6">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1">Nama Obat</label>
                        <input class="form-control" name="nama" id="exampleFormControlInput1" type="text" placeholder="" value="{{ $data->nama ?? null }}">
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1">Nomor Batch</label>
                        <input class="form-control" name="no_batch" id="exampleFormControlInput1" type="text" placeholder="" value="{{ $data->no_batch ?? null }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1">Tanggal Kadaluarsa</label>
                        <input class="form-control" name="tgl_kadaluarsa" id="exampleFormControlInput1" type="date" placeholder="" value="{{ $data->tgl_kadaluarsa ?? null }}">
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1">Kuantitas</label>
                        <input class="form-control" name="stok" id="exampleFormControlInput1" type="number" placeholder="" value="{{ $data->stok ?? null }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1">Tanggal Penerimaan</label>
                        <input class="form-control" name="tgl_penerimaan" id="exampleFormControlInput1" type="date" placeholder="" value="{{ $data->tgl_penerimaan ?? null }}">
                    </div>
                </div>
                <div class="col-4">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1">Harga Beli</label>
                        <input class="form-control" name="harga_beli" id="exampleFormControlInput1" type="number" placeholder="" value="{{ $data->harga_beli ?? null }}">
                    </div>
                </div>
                <div class="col-4">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1">Harga Jual</label>
                        <input class="form-control" name="harga_jual" id="exampleFormControlInput1" type="number" placeholder="" value="{{ $data->harga_jual ?? null }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1">Catatan</label>
                        <textarea class="form-control" name="catatan" id="exampleFormControlTextarea1" rows="3">{{ $data->catatan ?? null }}</textarea>
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
