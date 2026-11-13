<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with('anggota')
            ->latest('tanggal_transaksi')
            ->latest()
            ->paginate(15);

        return view('transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        $anggotas = Anggota::orderBy('nama')->get(['id', 'nomor_anggota', 'nama']);

        return view('transaksi.create', compact('anggotas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'anggota_id' => ['required', 'integer', 'exists:anggotas,id'],
            'kode_transaksi' => ['required', 'string', 'max:30', 'unique:transaksis,kode_transaksi'],
            'jenis_transaksi' => ['required', Rule::in(['simpanan', 'pinjaman'])],
            'jumlah' => ['required', 'numeric', 'min:0.01'],
            'tanggal_transaksi' => ['required', 'date'],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ]);

        Transaksi::create($validated);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function show(Transaksi $transaksi)
    {
        $transaksi->load('anggota');

        return view('transaksi.show', compact('transaksi'));
    }

    public function edit(Transaksi $transaksi)
    {
        $anggotas = Anggota::orderBy('nama')->get(['id', 'nomor_anggota', 'nama']);

        return view('transaksi.edit', compact('transaksi', 'anggotas'));
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        $validated = $request->validate([
            'anggota_id' => ['required', 'integer', 'exists:anggotas,id'],
            'kode_transaksi' => [
                'required',
                'string',
                'max:30',
                Rule::unique('transaksis', 'kode_transaksi')->ignore($transaksi->id),
            ],
            'jenis_transaksi' => ['required', Rule::in(['simpanan', 'pinjaman'])],
            'jumlah' => ['required', 'numeric', 'min:0.01'],
            'tanggal_transaksi' => ['required', 'date'],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ]);

        $transaksi->update($validated);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}
