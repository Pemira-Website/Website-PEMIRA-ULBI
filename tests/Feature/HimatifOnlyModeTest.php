<?php

namespace Tests\Feature;

use App\Models\Paslon;
use App\Models\Pemilih;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class HimatifOnlyModeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'pemira.period' => '2026/2027',
            'pemira.enabled_vote_types' => ['himatif'],
            'pemira.public_result_types' => ['himatif'],
        ]);
    }

    public function test_himatif_menu_hides_presma_and_uses_current_period(): void
    {
        $pemilih = $this->createPemilih();
        $this->createPaslon('presma');
        $this->createPaslon('himatif', ['paslon_ke' => 2]);

        $response = $this->withSession([
            'npm' => $pemilih->npm,
            'prodi' => $pemilih->prodi,
        ])->get(route('menuvote', ['prodi' => $pemilih->prodi]));

        $response->assertOk();
        $response->assertSee('Ketua Himatif');
        $response->assertSee('Periode 2026/2027');
        $response->assertDontSee('Presma Kema ULBI');
        $response->assertDontSee(route('vote.show', ['jenis_pemilihan' => 'presma']), false);
    }

    public function test_disabled_presma_page_cannot_be_accessed_directly(): void
    {
        $pemilih = $this->createPemilih();
        $this->createPaslon('presma');

        $response = $this->withSession([
            'npm' => $pemilih->npm,
            'prodi' => $pemilih->prodi,
        ])->get(route('vote.show', ['jenis_pemilihan' => 'presma']));

        $response->assertRedirect(route('menuvote', ['prodi' => $pemilih->prodi]));
        $response->assertSessionHas('error', 'Jenis pemilihan sedang tidak aktif.');
    }

    public function test_disabled_presma_vote_cannot_be_submitted_directly(): void
    {
        $pemilih = $this->createPemilih();
        $paslon = $this->createPaslon('presma');
        Queue::fake();

        $response = $this->from('/vote/presma')
            ->withSession([
                'npm' => $pemilih->npm,
                'prodi' => $pemilih->prodi,
            ])->post(route('vote.add'), [
                'paslon_id' => $paslon->id,
                'jenis_vote' => 'presma',
            ]);

        $response->assertRedirect('/vote/presma');
        $response->assertSessionHasErrors(['jenis_vote']);
        Queue::assertNothingPushed();
    }

    public function test_completed_himatif_voter_cannot_login_again(): void
    {
        $pemilih = $this->createPemilih();
        $pemilih->update([
            'pml_hima' => 1,
            'hima_status' => Pemilih::STATUS_COMPLETED,
        ]);

        $response = $this->from(route('login'))->post(route('login'), [
            'npm' => $pemilih->npm,
            'password' => 'secret',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors(['error']);
    }

    public function test_public_results_only_show_himatif(): void
    {
        $this->createPaslon('presma');
        $this->createPaslon('himatif', ['paslon_ke' => 2]);
        $this->createPaslon('himagis', ['paslon_ke' => 3]);

        $response = $this->get(route('hasilvote'));

        $response->assertOk();
        $response->assertSee('Pemilihan himatif');
        $response->assertDontSee('Pemilihan presma');
        $response->assertDontSee('Pemilihan himagis');
    }

    private function createPemilih(): Pemilih
    {
        return Pemilih::create([
            'npm' => '550001',
            'nama' => 'Pemilih Himatif',
            'prodi' => 'D3 Teknik Informatika',
            'password' => bcrypt('secret'),
            'total_vote' => 0,
            'pml_presma' => 0,
            'presma_status' => Pemilih::STATUS_NOT_VOTED,
            'pml_hima' => 0,
            'hima_status' => Pemilih::STATUS_NOT_VOTED,
            'jenis_pemilihan' => 'presma,himatif',
        ]);
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
