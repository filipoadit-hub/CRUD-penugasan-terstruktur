<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AnggotaController extends Controller
{
    /**
     * Menampilkan daftar anggota.
     */
    public function index()
    {
        $anggotas = Anggota::with('user')->latest()->get();

        return view('anggota.index', compact('anggotas'));
    }

    /**
     * Menampilkan form untuk menambah anggota baru.
     */
    public function create()
    {
        return view('anggota.create');
    }

    /**
     * Menyimpan data anggota baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_anggota' => ['required', 'string', 'max:20', 'unique:anggotas,nomor_anggota'],
            'nama' => ['required', 'string', 'max:100'],
            'alamat' => ['required', 'string'],
            'telepon' => ['required', 'string', 'max:20'],
        ]);

        $validated['user_id'] = Auth::id();

        Anggota::create($validated);

        return redirect()->route('anggota.index')->with('success', 'Data anggota berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail anggota.
     */
    public function show(Anggota $anggota)
    {
        return view('anggota.show', compact('anggota'));
    }

    /**
     * Menampilkan form edit anggota.
     */
    public function edit(Anggota $anggota)
    {
        return view('anggota.edit', compact('anggota'));
    }

    /**
     * Memperbarui data anggota.
     */
    public function update(Request $request, Anggota $anggota)
    {
        $validated = $request->validate([
            'nomor_anggota' => ['required', 'string', 'max:20', Rule::unique('anggotas', 'nomor_anggota')->ignore($anggota->id)],
            'nama' => ['required', 'string', 'max:100'],
            'alamat' => ['required', 'string'],
            'telepon' => ['required', 'string', 'max:20'],
        ]);

        $anggota->update($validated);

        return redirect()->route('anggota.index')->with('success', 'Data anggota berhasil diperbarui.');
    }

    /**
     * Menghapus data anggota.
     */
    public function destroy(Anggota $anggota)
    {
        $anggota->delete();

        return redirect()->route('anggota.index')->with('success', 'Data anggota berhasil dihapus.');
    }
}
