@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Edit Data Anggota</div>
        <div class="card-body">
            <form action="{{ route('anggota.update', $anggota) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nomor_anggota" class="form-label">Nomor Anggota</label>
                    <input id="nomor_anggota" type="text" name="nomor_anggota" class="form-control @error('nomor_anggota') is-invalid @enderror" value="{{ old('nomor_anggota', $anggota->nomor_anggota) }}" maxlength="20" required>
                    @error('nomor_anggota') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input id="nama" type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $anggota->nama) }}" maxlength="100" required>
                    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea id="alamat" name="alamat" class="form-control @error('alamat') is-invalid @enderror" required>{{ old('alamat', $anggota->alamat) }}</textarea>
                    @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="telepon" class="form-label">Telepon</label>
                    <input id="telepon" type="text" name="telepon" class="form-control @error('telepon') is-invalid @enderror" value="{{ old('telepon', $anggota->telepon) }}" maxlength="20" required>
                    @error('telepon') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('anggota.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
