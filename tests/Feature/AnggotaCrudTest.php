<?php

namespace Tests\Feature;

use App\Models\Anggota;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnggotaCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_list_update_and_delete_members(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $memberData = [
            'nomor_anggota' => 'AG-001',
            'nama' => 'Budi Santoso',
            'alamat' => 'Jl. Merdeka',
            'telepon' => '08123456789',
        ];

        $this->post(route('anggota.store'), $memberData)
            ->assertRedirect(route('anggota.index'));

        $anggota = Anggota::where('nomor_anggota', 'AG-001')->firstOrFail();

        $this->assertSame($user->id, $anggota->user_id);
        $this->get(route('anggota.index'))
            ->assertOk()
            ->assertSee('Budi Santoso');

        $this->put(route('anggota.update', $anggota), [
            ...$memberData,
            'nama' => 'Budi Santoso Baru',
        ])->assertRedirect(route('anggota.index'))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('anggotas', [
            'id' => $anggota->id,
            'nama' => 'Budi Santoso Baru',
        ]);

        $this->delete(route('anggota.destroy', $anggota))
            ->assertRedirect(route('anggota.index'));

        $this->assertDatabaseMissing('anggotas', ['id' => $anggota->id]);
    }
}
