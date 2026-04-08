<?php

namespace Tests\Feature;

use App\Models\Paslon;
use App\Models\Pemilih;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaslonDetailViewTest extends TestCase
{
    use RefreshDatabase;

    public function test_paslon_profile_card_renders_clickable_detail_trigger(): void
    {
        $pemilih = $this->createPemilih();
        $this->createPaslon('presma');

        $response = $this->withSession([
            'npm' => $pemilih->npm,
            'prodi' => $pemilih->prodi,
        ])->get(route('vote.show', ['jenis_pemilihan' => 'presma']));

        $response->assertOk();
        $response->assertSee('data-detail-trigger="paslon-card"', false);
    }

    public function test_withdrawn_paslon_is_rendered_as_empty_slot(): void
    {
        $pemilih = $this->createPemilih([
            'npm' => '440001',
        ]);
        $this->createPaslon('presma', [
            'is_withdrawn' => true,
        ]);

        $response = $this->withSession([
            'npm' => $pemilih->npm,
            'prodi' => $pemilih->prodi,
        ])->get(route('vote.show', ['jenis_pemilihan' => 'presma']));

        $response->assertOk();
        $response->assertSee('Kotak Kosong');
        $response->assertSee('Tidak Bisa Dipilih');
        $response->assertDontSee('data-detail-trigger="paslon-card"', false);
    }

    private function createPemilih(array $overrides = []): Pemilih
    {
        return Pemilih::create(array_merge([
            'npm' => '440000',
            'nama' => 'Pemilih Test',
            'prodi' => 'D3 Teknik Informatika',
            'password' => bcrypt('secret'),
            'total_vote' => 0,
            'pml_presma' => 0,
            'presma_status' => Pemilih::STATUS_NOT_VOTED,
            'pml_hima' => 0,
            'hima_status' => Pemilih::STATUS_NOT_VOTED,
            'jenis_pemilihan' => 'presma,himatif',
        ], $overrides));
    }

    private function createPaslon(string $jenisPemilihan, array $overrides = []): Paslon
    {
        return Paslon::create(array_merge([
            'paslon_ke' => 1,
            'nm_ketua' => 'Ketua Test',
            'nm_wakil' => 'Wakil Test',
            'npm_ketua' => 100001,
            'npm_wakil' => 100002,
            'pd_ketua' => 'D3 Teknik Informatika',
            'pd_wakil' => 'D3 Teknik Informatika',
            'ang_ketua' => '2023',
            'jbt_ketua' => 'Ketua',
            'ang_wakil' => '2023',
            'jbt_wakil' => 'Wakil',
            'visi' => 'Visi test',
            'misi' => 'Misi test',
            'jenis_pemilihan' => $jenisPemilihan,
            'total_vote' => 0,
        ], $overrides));
    }
}
