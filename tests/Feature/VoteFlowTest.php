<?php

namespace Tests\Feature;

use App\Jobs\ProcessVote;
use App\Models\Paslon;
use App\Models\Pemilih;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\RateLimiter;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class VoteFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_rejects_tampered_payload_when_paslon_type_does_not_match_jenis_vote(): void
    {
        $pemilih = $this->createPemilih([
            'npm' => '220001',
            'jenis_pemilihan' => 'presma,himatif',
        ]);
        $paslonHima = $this->createPaslon('himatif');

        Queue::fake();
        $this->clearVoteThrottle($pemilih->npm);

        $response = $this->from('/vote/presma')
            ->withSession([
                'npm' => $pemilih->npm,
                'prodi' => $pemilih->prodi,
            ])
            ->post(route('vote.add'), [
                'paslon_id' => $paslonHima->id,
                'jenis_vote' => 'presma',
            ]);

        $response->assertRedirect('/vote/presma');
        $response->assertSessionHasErrors(['paslon_id']);
        Queue::assertNothingPushed();
    }

    public function test_rejects_vote_type_outside_pemilih_permissions(): void
    {
        $pemilih = $this->createPemilih([
            'npm' => '220002',
            'jenis_pemilihan' => 'presma,himatif',
        ]);
        $paslonHimagis = $this->createPaslon('himagis');

        Queue::fake();
        $this->clearVoteThrottle($pemilih->npm);

        $response = $this->from('/vote/himagis')
            ->withSession([
                'npm' => $pemilih->npm,
                'prodi' => $pemilih->prodi,
            ])
            ->post(route('vote.add'), [
                'paslon_id' => $paslonHimagis->id,
                'jenis_vote' => 'himagis',
            ]);

        $response->assertRedirect('/vote/himagis');
        $response->assertSessionHasErrors(['jenis_vote']);
        Queue::assertNothingPushed();
    }

    #[DataProvider('lockedPresmaStatusesProvider')]
    public function test_rejects_vote_when_presma_status_is_locked(string $lockedStatus, string $expectedMessage): void
    {
        $pemilih = $this->createPemilih([
            'npm' => '220003',
            'jenis_pemilihan' => 'presma,himatif',
            'presma_status' => $lockedStatus,
        ]);
        $paslonPresma = $this->createPaslon('presma');

        Queue::fake();
        $this->clearVoteThrottle($pemilih->npm);

        $response = $this->from('/vote/presma')
            ->withSession([
                'npm' => $pemilih->npm,
                'prodi' => $pemilih->prodi,
            ])
            ->post(route('vote.add'), [
                'paslon_id' => $paslonPresma->id,
                'jenis_vote' => 'presma',
            ]);

        $response->assertRedirect('/vote/presma');
        $response->assertSessionHas('error', $expectedMessage);
        Queue::assertNothingPushed();

        $pemilih->refresh();
        $this->assertSame($lockedStatus, $pemilih->presma_status);
    }

    public function test_dispatches_vote_job_for_valid_request_and_sets_pending_status(): void
    {
        $pemilih = $this->createPemilih([
            'npm' => '220004',
            'jenis_pemilihan' => 'presma,himatif',
            'presma_status' => Pemilih::STATUS_NOT_VOTED,
            'hima_status' => Pemilih::STATUS_NOT_VOTED,
        ]);
        $paslonPresma = $this->createPaslon('presma');

        Queue::fake();
        $this->clearVoteThrottle($pemilih->npm);

        $response = $this->from('/vote/presma')
            ->withSession([
                'npm' => $pemilih->npm,
                'prodi' => $pemilih->prodi,
            ])
            ->post(route('vote.add'), [
                'paslon_id' => $paslonPresma->id,
                'jenis_vote' => 'presma',
            ]);

        $response->assertRedirect(route('menuvote', ['prodi' => $pemilih->prodi]));
        $response->assertSessionHas('success');

        Queue::assertPushed(ProcessVote::class, function (ProcessVote $job) use ($pemilih, $paslonPresma) {
            return $job->pemilih_id === $pemilih->id
                && $job->paslon_id === $paslonPresma->id
                && $job->jenisVote === 'presma'
                && $job->himaType === 'himatif';
        });

        $pemilih->refresh();
        $this->assertSame(Pemilih::STATUS_PENDING, $pemilih->presma_status);
    }

    public function test_allows_vote_for_withdrawn_paslon_slot(): void
    {
        $pemilih = $this->createPemilih([
            'npm' => '220005',
            'jenis_pemilihan' => 'presma,himatif',
        ]);
        $withdrawnPaslon = $this->createPaslon('presma', [
            'is_withdrawn' => true,
        ]);

        Queue::fake();
        $this->clearVoteThrottle($pemilih->npm);

        $response = $this->from('/vote/presma')
            ->withSession([
                'npm' => $pemilih->npm,
                'prodi' => $pemilih->prodi,
            ])
            ->post(route('vote.add'), [
                'paslon_id' => $withdrawnPaslon->id,
                'jenis_vote' => 'presma',
            ]);

        $response->assertRedirect(route('menuvote', ['prodi' => $pemilih->prodi]));
        $response->assertSessionHas('success');

        Queue::assertPushed(ProcessVote::class, function (ProcessVote $job) use ($pemilih, $withdrawnPaslon) {
            return $job->pemilih_id === $pemilih->id
                && $job->paslon_id === $withdrawnPaslon->id
                && $job->jenisVote === 'presma'
                && $job->himaType === 'himatif';
        });
    }

    public static function lockedPresmaStatusesProvider(): array
    {
        return [
            'pending status' => [Pemilih::STATUS_PENDING, 'Vote Presma Anda sedang diproses.'],
            'completed status' => [Pemilih::STATUS_COMPLETED, 'Anda sudah memberikan vote untuk Presma.'],
        ];
    }

    private function clearVoteThrottle(string $npm): void
    {
        RateLimiter::clear('vote_throttle_'.$npm);
    }

    private function createPemilih(array $overrides = []): Pemilih
    {
        return Pemilih::create(array_merge([
            'npm' => '220000',
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
