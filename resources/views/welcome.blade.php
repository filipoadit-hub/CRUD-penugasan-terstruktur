@extends('layouts.app')

@section('content')
<div class="container text-center" style="margin-top: 10vh;">
    <h1 class="mb-4 fw-bold">Aplikasi Simpan Pinjam Filipo</h1>
    <p class="lead mb-4">Sistem informasi manajemen data anggota dan transaksi koperasi.</p>
    
    @guest
        <div class="d-flex justify-content-center gap-3">
            <a href="{{ route('login') }}" class="btn btn-primary px-4">Log in</a>
            <a href="{{ route('register') }}" class="btn btn-outline-primary px-4">Register</a>
        </div>
    @else
        <a href="{{ route('anggota.index') }}" class="btn btn-primary px-4">Masuk ke Dashboard</a>
    @endguest
</div>
@endsection