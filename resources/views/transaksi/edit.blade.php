@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">Edit Transaksi</div>
        <div class="card-body">
            <form action="{{ route('transaksi.update', $transaksi) }}" method="POST">
                @csrf
                @method('PUT')
                @include('transaksi._form', ['transaksi' => $transaksi])
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
