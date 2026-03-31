<?php

namespace Tests\Feature;

use App\Models\Paslon;
use App\Models\Pemilih;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MenuVoteVisibilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_hima_section_is_hidden_when_hima_has_no_paslon(): void
    {
        $pemilih = $this->createPemilih([
            'npm' => '330001',
            'prodi' => 'D3 Manajemen Pemasaran',
            'jenis_pemilihan' => 'presma,himanbis',
        ]);

        $this->createPaslon('presma');

        $response = $this->withSession([
            'npm' => $pemilih->npm,
            'prodi' => $pemilih->prodi,
        ])->get(route('menuvote', ['prodi' => $pemilih->prodi]));

        $response->assertOk();
        $response->assertDontSee(route('vote.show', ['jenis_pemilihan' => 'himanbis']), false);
        $response->assertDontSee('himanbis.png', false);
    }

    public function test_menu_is_treated_as_finished_when_only_presma_is_available(): void
    {
        $pemilih = $this->createPemilih([
            'npm' => '330002',
            'prodi' => 'D3 Manajemen Pemasaran',
            'jenis_pemilihan' => 'presma,himanbis',
            'presma_status' => Pemilih::STATUS_COMPLETED,
            'hima_status' => Pemilih::STATUS_NOT_VOTED,
            'pml_presma' => 1,
        ]);

        $this->createPaslon('presma');

        $response = $this->withSession([
            'npm' => $pemilih->npm,
            'prodi' => $pemilih->prodi,
        ])->get(route('menuvote', ['prodi' => $pemilih->prodi]));

        $response->assertOk();
        $response->assertSee('Seluruh hak suara Anda sudah terkunci.');
    }

    private function createPemilih(array $overrides = []): Pemilih
    {
        return Pemilih::create(array_merge([
            'npm' => '330000',
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
