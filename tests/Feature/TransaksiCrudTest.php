<?php

namespace Tests\Feature;

use App\Models\Anggota;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransaksiCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_list_update_and_delete_transactions(): void
    {
        $user = User::factory()->create();
        $anggota = Anggota::create([
            'user_id' => $user->id,
            'nomor_anggota' => 'AG-001',
            'nama' => 'Budi Santoso',
            'alamat' => 'Jl. Merdeka',
            'telepon' => '08123456789',
        ]);

        $this->actingAs($user);

        $transactionData = [
            'anggota_id' => $anggota->id,
            'kode_transaksi' => 'TRX-001',
            'jenis_transaksi' => 'simpanan',
            'jumlah' => '50000.00',
            'tanggal_transaksi' => '2026-11-13',
            'keterangan' => 'Setoran awal',
        ];

        $this->post(route('transaksi.store'), $transactionData)
            ->assertRedirect(route('transaksi.index'));

        $transaksi = Transaksi::where('kode_transaksi', 'TRX-001')->firstOrFail();

        $this->get(route('transaksi.index'))
            ->assertOk()
            ->assertSee('TRX-001')
            ->assertSee('Budi Santoso');

        $this->put(route('transaksi.update', $transaksi), [
            ...$transactionData,
            'jumlah' => '75000.00',
        ])->assertRedirect(route('transaksi.index'));

        $this->assertDatabaseHas('transaksis', [
            'id' => $transaksi->id,
            'jumlah' => '75000.00',
        ]);

        $this->delete(route('transaksi.destroy', $transaksi))
            ->assertRedirect(route('transaksi.index'));

        $this->assertDatabaseMissing('transaksis', ['id' => $transaksi->id]);
    }
}
