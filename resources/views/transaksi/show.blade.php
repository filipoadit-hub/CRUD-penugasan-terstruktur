@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Detail Transaksi</div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Kode Transaksi</dt>
                <dd class="col-sm-9">{{ $transaksi->kode_transaksi }}</dd>

                <dt class="col-sm-3">Anggota</dt>
                <dd class="col-sm-9">{{ $transaksi->anggota->nomor_anggota }} - {{ $transaksi->anggota->nama }}</dd>

                <dt class="col-sm-3">Jenis Transaksi</dt>
                <dd class="col-sm-9">{{ ucfirst($transaksi->jenis_transaksi) }}</dd>

                <dt class="col-sm-3">Jumlah</dt>
                <dd class="col-sm-9">Rp {{ number_format((float) $transaksi->jumlah, 2, ',', '.') }}</dd>

                <dt class="col-sm-3">Tanggal</dt>
                <dd class="col-sm-9">{{ $transaksi->tanggal_transaksi }}</dd>

                <dt class="col-sm-3">Keterangan</dt>
                <dd class="col-sm-9">{{ $transaksi->keterangan ?: '-' }}</dd>
            </dl>

            <a href="{{ route('transaksi.edit', $transaksi) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection
