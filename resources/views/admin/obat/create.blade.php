@extends('layouts.main')
@section('contentTitle')
    Manajemen Obat
@endsection

@section('content')
<div class="container">
    <div class="mx-3 card shadow mb-4">
        <div class="card-body">
        <form action="{{ route('manajemen-obat.store', ['id' => $data->id ?? null]) }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-6">
                    <div class="mb-3">
                        <label>Nama Obat</label>
                        <input class="form-control @error('nama') is-invalid @enderror" name="nama" type="text" placeholder="" value="{{ old('nama', $data->nama ?? null) }}">
                        @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label>Nomor Batch</label>
                        <input class="form-control @error('no_batch') is-invalid @enderror" name="no_batch" type="text" placeholder="" value="{{ old('no_batch', $data->no_batch ?? null) }}">
                        @error('no_batch') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="mb-3">
                        <label>Tanggal Kadaluarsa</label>
                        <input class="form-control @error('tgl_kadaluarsa') is-invalid @enderror" name="tgl_kadaluarsa" type="date" value="{{ old('tgl_kadaluarsa', $data->tgl_kadaluarsa ?? null) }}">
                        @error('tgl_kadaluarsa') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label>Kuantitas</label>
                        <input class="form-control @error('stok') is-invalid @enderror" name="stok" type="number" placeholder="" value="{{ old('stok', $data->stok ?? null) }}">
                        @error('stok') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <div class="mb-3">
                        <label>Tanggal Penerimaan</label>
                        <input class="form-control @error('tgl_penerimaan') is-invalid @enderror" name="tgl_penerimaan" type="date" value="{{ old('tgl_penerimaan', $data->tgl_penerimaan ?? null) }}">
                        @error('tgl_penerimaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-4">
                    <div class="mb-3">
                        <label>Harga Beli</label>
                        <input class="form-control input-rupiah @error('harga_beli') is-invalid @enderror" name="harga_beli" type="text" inputmode="numeric" placeholder="" value="{{ old('harga_beli', isset($data) ? number_format($data->harga_beli, 0, ',', '.') : '') }}">
                        @error('harga_beli') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-4">
                    <div class="mb-3">
                        <label>Harga Jual</label>
                        <input class="form-control input-rupiah @error('harga_jual') is-invalid @enderror" name="harga_jual" type="text" inputmode="numeric" placeholder="" value="{{ old('harga_jual', isset($data) ? number_format($data->harga_jual, 0, ',', '.') : '') }}">
                        @error('harga_jual') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                        <textarea class="form-control" name="catatan" rows="2">{{ old('catatan', $data->catatan ?? null) }}</textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label>Komposisi</label>
                        <textarea class="form-control" name="komposisi" rows="3" placeholder="Contoh: Paracetamol 500mg, Caffeine 50mg">{{ old('komposisi', $data->komposisi ?? null) }}</textarea>
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
    </div>
</div>
@endsection
