@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Tambah Data Anggota</div>
        <div class="card-body">
            <form action="{{ route('anggota.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Nomor Anggota</label>
                    <input type="text" name="nomor_anggota" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control" required></textarea>
                </div>
                <div class="mb-3">
                    <label>Telepon</label>
                    <input type="text" name="telepon" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('anggota.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection