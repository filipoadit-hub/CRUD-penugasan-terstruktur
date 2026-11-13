<?php

namespace Tests\Feature;

use App\Models\Anggota;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LaporanPdfTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_download_member_report_pdf(): void
    {
        $user = User::factory()->create();
        Anggota::create([
            'user_id' => $user->id,
            'nomor_anggota' => 'AG-001',
            'nama' => 'Budi Santoso',
            'alamat' => 'Jl. Merdeka',
            'telepon' => '08123456789',
        ]);

        $response = $this->actingAs($user)->get(route('laporan.anggota'));

        $response->assertOk()
            ->assertHeader('content-type', 'application/pdf');
        $this->assertStringStartsWith('%PDF-', $response->getContent());
        $this->assertStringContainsString(
            'laporan-anggota-',
            $response->headers->get('content-disposition')
        );
    }

    public function test_authenticated_user_can_download_transaction_report_pdf(): void
    {
        $user = User::factory()->create();
        $anggota = Anggota::create([
            'user_id' => $user->id,
            'nomor_anggota' => 'AG-001',
            'nama' => 'Budi Santoso',
            'alamat' => 'Jl. Merdeka',
            'telepon' => '08123456789',
        ]);
        Transaksi::create([
            'anggota_id' => $anggota->id,
            'kode_transaksi' => 'TRX-001',
            'jenis_transaksi' => 'simpanan',
            'jumlah' => '50000.00',
            'tanggal_transaksi' => '2026-11-13',
            'keterangan' => 'Setoran awal',
        ]);

        $response = $this->actingAs($user)->get(route('laporan.transaksi'));

        $response->assertOk()
            ->assertHeader('content-type', 'application/pdf');
        $this->assertStringStartsWith('%PDF-', $response->getContent());
        $this->assertStringContainsString(
            'laporan-transaksi-',
            $response->headers->get('content-disposition')
        );
    }
}
