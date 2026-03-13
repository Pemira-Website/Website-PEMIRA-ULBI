<?php

namespace App\Support;

class PemiraConfig
{
    public static function normalizeProdi(?string $prodi): ?string
    {
        if ($prodi === null || $prodi === '') {
            return null;
        }

        $aliases = config('pemira.prodi_aliases', []);

        return $aliases[$prodi] ?? $prodi;
    }

    public static function prodiToHimaMap(): array
    {
        return config('pemira.prodi_to_hima', []);
    }

    public static function himaForProdi(?string $prodi): ?string
    {
        $normalized = self::normalizeProdi($prodi);

        if ($normalized === null) {
            return null;
        }

        $map = self::prodiToHimaMap();

        return $map[$normalized] ?? null;
    }

    public static function prodisForHima(string $hima): array
    {
        $prodis = [];

        foreach (self::prodiToHimaMap() as $prodi => $mappedHima) {
            if ($mappedHima === $hima) {
                $prodis[] = $prodi;
            }
        }

        return $prodis;
    }

    public static function specialHima(): array
    {
        return config('pemira.special_hima', []);
    }

    public static function isSpecialHima(?string $hima): bool
    {
        if ($hima === null || $hima === '') {
            return false;
        }

        return in_array($hima, self::specialHima(), true);
    }

    public static function voteTypes(): array
    {
        return config('pemira.vote_types', []);
    }

    public static function allowedVoteTypesForProdi(?string $prodi): array
    {
        $hima = self::himaForProdi($prodi);

        if ($hima === null) {
            return ['presma'];
        }

        if (self::isSpecialHima($hima)) {
            return ['presma'];
        }

        return ['presma', $hima];
    }

    public static function resultVisibilityMode(): string
    {
        return (string) config('pemira.result_visibility_mode', 'live_public');
    }

    public static function isLivePublicMode(): bool
    {
        return self::resultVisibilityMode() === 'live_public';
    }

    public static function isClosedUntilEndMode(): bool
    {
        return self::resultVisibilityMode() === 'closed_until_end';
    }

    public static function isVotingClosed(): bool
    {
        $raw = config('pemira.voting_closed', false);

        if (is_bool($raw)) {
            return $raw;
        }

        if (is_int($raw)) {
            return $raw === 1;
        }

        if (is_string($raw)) {
            return in_array(strtolower($raw), ['1', 'true', 'yes', 'on'], true);
        }

        return false;
    }

    public static function canShowPublicResults(): bool
    {
        if (self::isLivePublicMode()) {
            return true;
        }

        if (self::isClosedUntilEndMode()) {
            return self::isVotingClosed();
        }

        return true;
    }

    public static function publicResultNotice(): string
    {
        if (self::canShowPublicResults()) {
            return 'Hasil sementara ditampilkan sesuai kebijakan publikasi.';
        }

        return 'Hasil sementara ditutup selama pemungutan berlangsung. Silakan cek kembali setelah pemungutan selesai.';
    }

    public static function resultPollingSeconds(): int
    {
        $seconds = (int) config('pemira.result_polling_seconds', 10);

        return max(5, min(120, $seconds));
    }

    public static function resultCacheTtlSeconds(): int
    {
        $seconds = (int) config('pemira.result_cache_ttl_seconds', 10);

        return max(5, min(120, $seconds));
    }

    public static function monitoringPendingAlertThreshold(): int
    {
        $value = (int) config('pemira.monitoring_pending_alert_threshold', 50);

        return max(1, $value);
    }

    public static function monitoringFailedAlertThreshold(): int
    {
        $value = (int) config('pemira.monitoring_failed_alert_threshold', 5);

        return max(1, $value);
    }

    public static function monitoringStaleProcessingMinutes(): int
    {
        $value = (int) config('pemira.monitoring_stale_processing_minutes', 10);

        return max(1, $value);
    }

    public static function monitoringQueueBacklogAlertThreshold(): int
    {
        $value = (int) config('pemira.monitoring_queue_backlog_alert_threshold', 100);

        return max(1, $value);
    }

    public static function privacyMode(): string
    {
        return (string) config('pemira.privacy_mode', 'auditable');
    }

    public static function isAuditableMode(): bool
    {
        return self::privacyMode() === 'auditable';
    }

    public static function isStrictAnonymousMode(): bool
    {
        return self::privacyMode() === 'strict_anonymous';
    }

    public static function publicPrivacyHeadline(): string
    {
        return self::isAuditableMode() ? 'Aman & Teraudit' : 'Aman & Anonim';
    }

    public static function publicPrivacyDescription(): string
    {
        if (self::isAuditableMode()) {
            return 'Sistem menjaga keamanan data pemilih dengan audit internal terbatas untuk integritas pemungutan suara.';
        }

        return 'Sistem dirancang tanpa relasi langsung pemilih-vote sehingga pilihan tidak dapat ditelusuri kembali ke identitas pemilih.';
    }

    public static function publicPrivacyFaqAnswer(): string
    {
        if (self::isAuditableMode()) {
            return 'Identitas digunakan untuk verifikasi hak pilih dan pencatatan audit internal terbatas. Akses jejak audit dibatasi untuk panitia berwenang demi integritas pemilihan.';
        }

        return 'Sistem menerapkan mode anonim ketat: identitas hanya untuk verifikasi hak pilih dan tidak disimpan bersama pilihan kandidat.';
    }

    public static function generateOtpCode(int $length = 6): string
    {
        $characters = 'ABCDEFGHJKMNPQRSTUVWXYZ23456789';
        $maxIndex = strlen($characters) - 1;
        $otp = '';

        for ($index = 0; $index < $length; $index++) {
            $otp .= $characters[random_int(0, $maxIndex)];
        }

        return $otp;
    }
}
