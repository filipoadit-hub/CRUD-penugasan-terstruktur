@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Detail Anggota</div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Nomor Anggota</dt>
                <dd class="col-sm-9">{{ $anggota->nomor_anggota }}</dd>

                <dt class="col-sm-3">Nama</dt>
                <dd class="col-sm-9">{{ $anggota->nama }}</dd>

                <dt class="col-sm-3">Alamat</dt>
                <dd class="col-sm-9">{{ $anggota->alamat }}</dd>

                <dt class="col-sm-3">Telepon</dt>
                <dd class="col-sm-9">{{ $anggota->telepon }}</dd>
            </dl>

            <a href="{{ route('anggota.edit', $anggota) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('anggota.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection
