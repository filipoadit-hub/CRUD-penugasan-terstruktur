@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Data Anggota</span>
                    <div class="d-flex gap-2">
                        <a href="{{ route('laporan.anggota') }}" class="btn btn-outline-danger btn-sm">Cetak PDF</a>
                        <a href="{{ route('anggota.create') }}" class="btn btn-primary btn-sm">Tambah Anggota</a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Anggota</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>Telepon</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($anggotas as $index => $anggota)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $anggota->nomor_anggota }}</td>
                                        <td>{{ $anggota->nama }}</td>
                                        <td>{{ $anggota->alamat }}</td>
                                        <td>{{ $anggota->telepon }}</td>
                                        <td>
                                            <a href="{{ route('anggota.edit', $anggota->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                            <form action="{{ route('anggota.destroy', $anggota->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Data anggota belum tersedia.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection