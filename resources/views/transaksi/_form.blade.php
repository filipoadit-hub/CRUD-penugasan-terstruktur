<div class="mb-3">
    <label for="anggota_id" class="form-label">Anggota</label>
    <select id="anggota_id" name="anggota_id" class="form-select @error('anggota_id') is-invalid @enderror" required>
        <option value="">Pilih anggota</option>
        @foreach ($anggotas as $anggota)
            <option value="{{ $anggota->id }}" @selected(old('anggota_id', isset($transaksi) ? $transaksi->anggota_id : '') == $anggota->id)>
                {{ $anggota->nomor_anggota }} - {{ $anggota->nama }}
            </option>
        @endforeach
    </select>
    @error('anggota_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="kode_transaksi" class="form-label">Kode Transaksi</label>
    <input id="kode_transaksi" type="text" name="kode_transaksi" class="form-control @error('kode_transaksi') is-invalid @enderror" value="{{ old('kode_transaksi', isset($transaksi) ? $transaksi->kode_transaksi : '') }}" maxlength="30" required>
    @error('kode_transaksi') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="jenis_transaksi" class="form-label">Jenis Transaksi</label>
    <select id="jenis_transaksi" name="jenis_transaksi" class="form-select @error('jenis_transaksi') is-invalid @enderror" required>
        <option value="">Pilih jenis</option>
        <option value="simpanan" @selected(old('jenis_transaksi', isset($transaksi) ? $transaksi->jenis_transaksi : '') === 'simpanan')>Simpanan</option>
        <option value="pinjaman" @selected(old('jenis_transaksi', isset($transaksi) ? $transaksi->jenis_transaksi : '') === 'pinjaman')>Pinjaman</option>
    </select>
    @error('jenis_transaksi') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="jumlah" class="form-label">Jumlah (Rp)</label>
    <input id="jumlah" type="number" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror" value="{{ old('jumlah', isset($transaksi) ? $transaksi->jumlah : '') }}" min="0.01" step="0.01" required>
    @error('jumlah') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="tanggal_transaksi" class="form-label">Tanggal Transaksi</label>
    <input id="tanggal_transaksi" type="date" name="tanggal_transaksi" class="form-control @error('tanggal_transaksi') is-invalid @enderror" value="{{ old('tanggal_transaksi', isset($transaksi) ? $transaksi->tanggal_transaksi : now()->toDateString()) }}" required>
    @error('tanggal_transaksi') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label for="keterangan" class="form-label">Keterangan</label>
    <textarea id="keterangan" name="keterangan" maxlength="255" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan', isset($transaksi) ? $transaksi->keterangan : '') }}</textarea>
    @error('keterangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
