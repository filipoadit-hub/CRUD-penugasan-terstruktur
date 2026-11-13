@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Data Transaksi</span>
            <div class="d-flex gap-2">
                <a href="{{ route('laporan.transaksi') }}" class="btn btn-outline-danger btn-sm">Cetak PDF</a>
                <a href="{{ route('transaksi.create') }}" class="btn btn-primary btn-sm">Tambah Transaksi</a>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Anggota</th>
                            <th>Jenis</th>
                            <th>Jumlah</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaksis as $index => $transaksi)
                            <tr>
                                <td>{{ $transaksis->firstItem() + $index }}</td>
                                <td>{{ $transaksi->kode_transaksi }}</td>
                                <td>{{ $transaksi->anggota->nama }}</td>
                                <td>{{ ucfirst($transaksi->jenis_transaksi) }}</td>
                                <td>Rp {{ number_format((float) $transaksi->jumlah, 2, ',', '.') }}</td>
                                <td>{{ $transaksi->tanggal_transaksi }}</td>
                                <td class="text-nowrap">
                                    <a href="{{ route('transaksi.show', $transaksi) }}" class="btn btn-info btn-sm">Detail</a>
                                    <a href="{{ route('transaksi.edit', $transaksi) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('transaksi.destroy', $transaksi) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Data transaksi belum tersedia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $transaksis->links() }}
        </div>
    </div>
</div>
@endsection
