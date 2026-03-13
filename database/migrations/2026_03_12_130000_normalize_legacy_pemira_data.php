<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $prodiAliases = [];
    private array $prodiToHima = [];
    private array $specialHima = [];
    private array $voteTypeKeys = [];

    private const STATUS_NOT_VOTED = 'not_voted';
    private const STATUS_PENDING = 'pending';
    private const STATUS_COMPLETED = 'completed';
    private const STATUS_FAILED = 'failed';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->prodiAliases = config('pemira.prodi_aliases', []);
        $this->prodiToHima = config('pemira.prodi_to_hima', []);
        $this->specialHima = config('pemira.special_hima', []);
        $this->voteTypeKeys = array_keys(config('pemira.vote_types', []));

        if (Schema::hasTable('pemilih')) {
            $this->normalizePemilih();
        }

        if (Schema::hasTable('paslon')) {
            $this->normalizePaslon();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Data normalization migration is intentionally irreversible.
    }

    private function normalizePemilih(): void
    {
        $hasPmlPresma = Schema::hasColumn('pemilih', 'pml_presma');
        $hasPmlHima = Schema::hasColumn('pemilih', 'pml_hima');
        $hasPresmaStatus = Schema::hasColumn('pemilih', 'presma_status');
        $hasHimaStatus = Schema::hasColumn('pemilih', 'hima_status');
        $hasTotalVote = Schema::hasColumn('pemilih', 'total_vote');
        $hasJenis = Schema::hasColumn('pemilih', 'jenis_pemilihan');
        $hasProdi = Schema::hasColumn('pemilih', 'prodi');

        DB::table('pemilih')
            ->select([
                'id',
                $hasProdi ? 'prodi' : DB::raw('NULL as prodi'),
                $hasJenis ? 'jenis_pemilihan' : DB::raw('NULL as jenis_pemilihan'),
                $hasPmlPresma ? 'pml_presma' : DB::raw('0 as pml_presma'),
                $hasPmlHima ? 'pml_hima' : DB::raw('0 as pml_hima'),
                $hasPresmaStatus ? 'presma_status' : DB::raw("NULL as presma_status"),
                $hasHimaStatus ? 'hima_status' : DB::raw("NULL as hima_status"),
            ])
            ->orderBy('id')
            ->chunkById(200, function ($rows) use ($hasPmlPresma, $hasPmlHima, $hasPresmaStatus, $hasHimaStatus, $hasTotalVote, $hasJenis, $hasProdi): void {
                foreach ($rows as $row) {
                    $normalizedProdi = $this->normalizeProdi($row->prodi);
                    if ($normalizedProdi === null) {
                        $normalizedProdi = is_string($row->prodi) ? trim($row->prodi) : '';
                    }
                    $himaFromProdi = $this->himaForProdi($normalizedProdi);
                    $allowedVoteTypes = $this->allowedVoteTypesForProdi($normalizedProdi);

                    $pmlPresma = $this->normalizeBinaryValue($row->pml_presma);
                    $pmlHima = $this->normalizeBinaryValue($row->pml_hima);

                    if ($this->isSpecialHima($himaFromProdi)) {
                        $pmlHima = 0;
                    }

                    $presmaStatus = $this->normalizeVoteStatus((string) $row->presma_status, $pmlPresma === 1);
                    $himaStatus = $this->normalizeVoteStatus((string) $row->hima_status, $pmlHima === 1);

                    if ($this->isSpecialHima($himaFromProdi)) {
                        $himaStatus = self::STATUS_NOT_VOTED;
                    }

                    $normalizedJenisVote = $this->normalizeJenisPemilihan($row->jenis_pemilihan, $allowedVoteTypes);
                    $totalVote = $pmlPresma + $pmlHima;

                    $updates = [];

                    if ($hasProdi && $normalizedProdi !== ($row->prodi ?? null)) {
                        $updates['prodi'] = $normalizedProdi;
                    }

                    if ($hasJenis && $normalizedJenisVote !== ($row->jenis_pemilihan ?? null)) {
                        $updates['jenis_pemilihan'] = $normalizedJenisVote;
                    }

                    if ($hasPmlPresma && (int) $row->pml_presma !== $pmlPresma) {
                        $updates['pml_presma'] = $pmlPresma;
                    }

                    if ($hasPmlHima && (int) $row->pml_hima !== $pmlHima) {
                        $updates['pml_hima'] = $pmlHima;
                    }

                    if ($hasPresmaStatus && (string) $row->presma_status !== $presmaStatus) {
                        $updates['presma_status'] = $presmaStatus;
                    }

                    if ($hasHimaStatus && (string) $row->hima_status !== $himaStatus) {
                        $updates['hima_status'] = $himaStatus;
                    }

                    if ($hasTotalVote) {
                        $updates['total_vote'] = $totalVote;
                    }

                    if ($updates !== []) {
                        DB::table('pemilih')->where('id', $row->id)->update($updates);
                    }
                }
            });
    }

    private function normalizePaslon(): void
    {
        $hasPdKetua = Schema::hasColumn('paslon', 'pd_ketua');
        $hasPdWakil = Schema::hasColumn('paslon', 'pd_wakil');
        $hasJenis = Schema::hasColumn('paslon', 'jenis_pemilihan');
        $hasJbtKetua = Schema::hasColumn('paslon', 'jbt_ketua');
        $hasJbtWakil = Schema::hasColumn('paslon', 'jbt_wakil');
        $hasTotalVote = Schema::hasColumn('paslon', 'total_vote');

        DB::table('paslon')
            ->select([
                'id',
                $hasPdKetua ? 'pd_ketua' : DB::raw('NULL as pd_ketua'),
                $hasPdWakil ? 'pd_wakil' : DB::raw('NULL as pd_wakil'),
                $hasJenis ? 'jenis_pemilihan' : DB::raw('NULL as jenis_pemilihan'),
                $hasJbtKetua ? 'jbt_ketua' : DB::raw('NULL as jbt_ketua'),
                $hasJbtWakil ? 'jbt_wakil' : DB::raw('NULL as jbt_wakil'),
                $hasTotalVote ? 'total_vote' : DB::raw('0 as total_vote'),
            ])
            ->orderBy('id')
            ->chunkById(200, function ($rows) use ($hasPdKetua, $hasPdWakil, $hasJenis, $hasJbtKetua, $hasJbtWakil, $hasTotalVote): void {
                foreach ($rows as $row) {
                    $normalizedPdKetua = $this->normalizeProdi($row->pd_ketua);
                    $normalizedPdWakil = $this->normalizeProdi($row->pd_wakil);
                    if ($normalizedPdKetua === null) {
                        $normalizedPdKetua = is_string($row->pd_ketua) ? trim($row->pd_ketua) : '';
                    }
                    if ($normalizedPdWakil === null) {
                        $normalizedPdWakil = is_string($row->pd_wakil) ? trim($row->pd_wakil) : '';
                    }

                    $normalizedJenis = $this->normalizePaslonJenisPemilihan(
                        $row->jenis_pemilihan,
                        $normalizedPdKetua,
                        $normalizedPdWakil,
                        (string) $row->jbt_ketua
                    );

                    [$normalizedJabatanKetua, $normalizedJabatanWakil] = $this->normalizeJabatan($normalizedJenis);
                    $normalizedTotalVote = max(0, (int) $row->total_vote);

                    $updates = [];

                    if ($hasPdKetua && $normalizedPdKetua !== ($row->pd_ketua ?? null)) {
                        $updates['pd_ketua'] = $normalizedPdKetua;
                    }

                    if ($hasPdWakil && $normalizedPdWakil !== ($row->pd_wakil ?? null)) {
                        $updates['pd_wakil'] = $normalizedPdWakil;
                    }

                    if ($hasJenis && $normalizedJenis !== ($row->jenis_pemilihan ?? null)) {
                        $updates['jenis_pemilihan'] = $normalizedJenis;
                    }

                    if ($hasJbtKetua && $normalizedJabatanKetua !== ($row->jbt_ketua ?? null)) {
                        $updates['jbt_ketua'] = $normalizedJabatanKetua;
                    }

                    if ($hasJbtWakil && $normalizedJabatanWakil !== ($row->jbt_wakil ?? null)) {
                        $updates['jbt_wakil'] = $normalizedJabatanWakil;
                    }

                    if ($hasTotalVote) {
                        $updates['total_vote'] = $normalizedTotalVote;
                    }

                    if ($updates !== []) {
                        DB::table('paslon')->where('id', $row->id)->update($updates);
                    }
                }
            });
    }

    private function normalizeProdi(?string $prodi): ?string
    {
        $prodi = is_string($prodi) ? trim($prodi) : null;

        if ($prodi === null || $prodi === '') {
            return null;
        }

        return $this->prodiAliases[$prodi] ?? $prodi;
    }

    private function himaForProdi(?string $prodi): ?string
    {
        if ($prodi === null || $prodi === '') {
            return null;
        }

        return $this->prodiToHima[$prodi] ?? null;
    }

    private function allowedVoteTypesForProdi(?string $prodi): array
    {
        $hima = $this->himaForProdi($prodi);

        if ($hima === null) {
            return ['presma'];
        }

        if ($this->isSpecialHima($hima)) {
            return ['presma'];
        }

        return ['presma', $hima];
    }

    private function isSpecialHima(?string $hima): bool
    {
        if ($hima === null || $hima === '') {
            return false;
        }

        return in_array($hima, $this->specialHima, true);
    }

    private function normalizeBinaryValue(mixed $value): int
    {
        return ((int) $value) > 0 ? 1 : 0;
    }

    private function normalizeVoteStatus(string $status, bool $isCompleted): string
    {
        if ($isCompleted) {
            return self::STATUS_COMPLETED;
        }

        $status = trim(strtolower($status));
        $allowed = [self::STATUS_NOT_VOTED, self::STATUS_PENDING, self::STATUS_FAILED];

        return in_array($status, $allowed, true) ? $status : self::STATUS_NOT_VOTED;
    }

    private function normalizeJenisPemilihan(mixed $rawJenis, array $fallbackVoteTypes): string
    {
        $tokens = preg_split('/[\s,;|]+/', strtolower(trim((string) $rawJenis)));
        $tokens = array_filter($tokens, static fn ($token) => $token !== '');

        $normalized = [];
        foreach ($tokens as $token) {
            if (in_array($token, $this->voteTypeKeys, true)) {
                $normalized[] = $token;
            }
        }

        $normalized = array_values(array_unique($normalized));

        if ($normalized === []) {
            $normalized = $fallbackVoteTypes;
        }

        // Presma selalu ditaruh di posisi pertama agar konsisten.
        if (in_array('presma', $normalized, true)) {
            $normalized = array_values(array_diff($normalized, ['presma']));
            array_unshift($normalized, 'presma');
        }

        return implode(',', $normalized);
    }

    private function normalizePaslonJenisPemilihan(
        mixed $rawJenis,
        ?string $pdKetua,
        ?string $pdWakil,
        string $jabatanKetua
    ): string {
        $jenis = strtolower(trim((string) $rawJenis));

        if (in_array($jenis, $this->voteTypeKeys, true)) {
            return $jenis;
        }

        $himaKetua = $this->himaForProdi($pdKetua);
        $himaWakil = $this->himaForProdi($pdWakil);

        if ($himaKetua !== null && $himaKetua === $himaWakil) {
            return $himaKetua;
        }

        if ($himaKetua !== null && $himaWakil === null) {
            return $himaKetua;
        }

        if ($himaWakil !== null && $himaKetua === null) {
            return $himaWakil;
        }

        if (str_contains(strtolower($jabatanKetua), 'presiden')) {
            return 'presma';
        }

        return 'presma';
    }

    private function normalizeJabatan(string $jenisPemilihan): array
    {
        if ($jenisPemilihan === 'presma') {
            return ['Presiden Mahasiswa', 'Wakil Presiden Mahasiswa'];
        }

        return ['Ketua Himpunan', 'Wakil Ketua Himpunan'];
    }
};
