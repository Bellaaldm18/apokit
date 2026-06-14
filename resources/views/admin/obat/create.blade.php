@extends('layouts.main')
@section('contentTitle')
    Manajemen Obat
@endsection

@section('content')
    <div class="container-fluid bg-white mx-3 p-4 rounded card shadow">
        <form action="{{ route('manajemen-obat.store', ['id' => request('id')]) }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-6">
                    <div class="mb-3">
                        <label>Nama Obat</label>
                        <input class="form-control" name="nama" type="text" placeholder="" value="{{ $data->nama ?? null }}">
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label>Nomor Batch</label>
                        <input class="form-control" name="no_batch" type="text" placeholder="" value="{{ $data->no_batch ?? null }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="mb-3">
                        <label>Tanggal Kadaluarsa</label>
                        <input class="form-control" name="tgl_kadaluarsa" type="date" value="{{ $data->tgl_kadaluarsa ?? null }}">
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label>Kuantitas</label>
                        <input class="form-control" name="stok" type="number" placeholder="" value="{{ $data->stok ?? null }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <div class="mb-3">
                        <label>Tanggal Penerimaan</label>
                        <input class="form-control" name="tgl_penerimaan" type="date" value="{{ $data->tgl_penerimaan ?? null }}">
                    </div>
                </div>
                <div class="col-4">
                    <div class="mb-3">
                        <label>Harga Beli</label>
                        <input class="form-control" name="harga_beli" type="number" placeholder="" value="{{ $data->harga_beli ?? null }}">
                    </div>
                </div>
                <div class="col-4">
                    <div class="mb-3">
                        <label>Harga Jual</label>
                        <input class="form-control" name="harga_jual" type="number" placeholder="" value="{{ $data->harga_jual ?? null }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="mb-3">
                        <label>Jenis Obat</label>
                        <div class="d-flex align-items-center mt-2">
                            <div class="form-check mr-4">
                                <input class="form-check-input" type="radio" name="is_obat_keras" id="obat_bebas" value="0"
                                    {{ (isset($data) && $data->is_obat_keras == 0) || !isset($data) ? 'checked' : '' }}>
                                <label class="form-check-label" for="obat_bebas">
                                    <span class="badge badge-success px-2 py-1">Obat Bebas</span>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_obat_keras" id="obat_keras" value="1"
                                    {{ isset($data) && $data->is_obat_keras == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="obat_keras">
                                    <span class="badge badge-danger px-2 py-1">Obat Keras (Resep)</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label>Catatan</label>
                        <textarea class="form-control" name="catatan" rows="2">{{ $data->catatan ?? null }}</textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label>Komposisi</label>
                        <textarea class="form-control" name="komposisi" rows="3" placeholder="Contoh: Paracetamol 500mg, Caffeine 50mg">{{ $data->komposisi ?? null }}</textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-auto">
                    <button type="submit" class="btn btn-success mb-3">Simpan</button>
                    <a href="{{ url('dashboard/manajemen-obat') }}" class="btn btn-secondary mb-3 ml-2">Batal</a>
                </div>
            </div>
        </form>
    </div>
@endsection
