@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Tambah Transaksi</div>
        <div class="card-body">
            @if ($anggotas->isEmpty())
                <div class="alert alert-warning">
                    Belum ada anggota. Tambahkan data anggota terlebih dahulu.
                </div>
                <a href="{{ route('anggota.create') }}" class="btn btn-primary">Tambah Anggota</a>
                <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Kembali</a>
            @else
                <form action="{{ route('transaksi.store') }}" method="POST">
                    @csrf
                    @include('transaksi._form')
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection
