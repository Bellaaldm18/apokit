@extends('layouts.main')
@section('contentTitle')
    Biaya Operasional
@endsection

@section('content')
<div class="container">
    <div class="mx-3 card shadow mb-4">
        <div class="card-body">
        <form action="{{ route('biaya.store', ['id' => $data->id ?? null]) }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-6">
                    <div class="mb-3">
                        <label for="tanggal">Tanggal</label>
                        <input class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" id="tanggal" type="date" value="{{ old('tanggal', $data->tanggal ?? null) }}">
                        @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label for="nama_biaya">Nama Biaya</label>
                        <input class="form-control @error('nama_biaya') is-invalid @enderror" name="nama_biaya" id="nama_biaya" type="text" placeholder="Contoh: Gaji Karyawan, Listrik, Pajak" value="{{ old('nama_biaya', $data->nama_biaya ?? null) }}">
                        @error('nama_biaya') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="mb-3">
                        <label for="kategori">Kategori</label>
                        <select class="form-control @error('kategori') is-invalid @enderror" name="kategori" id="kategori">
                            <option value="operasional" {{ old('kategori', $data->kategori ?? '') == 'operasional' ? 'selected' : '' }}>Operasional (gaji, listrik, air, internet, sewa, kemasan, dll)</option>
                            <option value="non_operasional" {{ old('kategori', $data->kategori ?? '') == 'non_operasional' ? 'selected' : '' }}>Non-Operasional (pajak, biaya admin bank, bunga pinjaman, dll)</option>
                        </select>
                        @error('kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label for="jumlah">Jumlah (Rp)</label>
                        <input class="form-control input-rupiah @error('jumlah') is-invalid @enderror" name="jumlah" id="jumlah" type="text" inputmode="numeric" value="{{ old('jumlah', isset($data) ? number_format($data->jumlah, 0, ',', '.') : '') }}">
                        @error('jumlah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="keterangan">Keterangan</label>
                        <textarea class="form-control" name="keterangan" id="keterangan" rows="3">{{ old('keterangan', $data->keterangan ?? null) }}</textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-auto">
                    <button type="submit" class="btn btn-success mb-3">Simpan</button>
                    <a href="{{ route('biaya.index') }}" class="btn btn-secondary mb-3 ml-2">Batal</a>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>
@endsection
