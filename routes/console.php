<?php

use App\Models\AuditLog;
use App\Models\Pemilih;
use App\Support\PemiraConfig;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('pemira:monitor {--json : Output result as JSON} {--fail-on-alert : Return exit code 1 if alerts exist}', function () {
    if (!Schema::hasTable('pemilih') || !Schema::hasTable('audit_logs')) {
        $errorPayload = [
            'ok' => false,
            'message' => 'Tabel pemilih/audit_logs belum tersedia. Jalankan migrasi terlebih dahulu.',
        ];

        if ($this->option('json')) {
            $this->line(json_encode($errorPayload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        } else {
            $this->error($errorPayload['message']);
        }

        return 1;
    }

    $pendingThreshold = PemiraConfig::monitoringPendingAlertThreshold();
    $failedThreshold = PemiraConfig::monitoringFailedAlertThreshold();
    $staleMinutesThreshold = PemiraConfig::monitoringStaleProcessingMinutes();
    $queueBacklogThreshold = PemiraConfig::monitoringQueueBacklogAlertThreshold();

    $pendingPresma = Pemilih::where('presma_status', Pemilih::STATUS_PENDING)->count();
    $pendingHima = Pemilih::where('hima_status', Pemilih::STATUS_PENDING)->count();
    $pendingVotes = $pendingPresma + $pendingHima;

    $failedPresma = Pemilih::where('presma_status', Pemilih::STATUS_FAILED)->count();
    $failedHima = Pemilih::where('hima_status', Pemilih::STATUS_FAILED)->count();
    $failedVotes = $failedPresma + $failedHima;

    $processingCount = AuditLog::where('status', 'processing')->count();
    $staleProcessing = AuditLog::where('status', 'processing')
        ->where('updated_at', '<', now()->subMinutes($staleMinutesThreshold))
        ->count();
    $failedAuditLogs = AuditLog::where('status', 'like', 'failed%')->count();
    $pendingQueueAuditLogs = AuditLog::where('status', 'pending_queue')->count();

    $jobsBacklog = null;
    if (Schema::hasTable('jobs')) {
        $jobsBacklog = DB::table('jobs')->count();
    }

    $alerts = [];

    if ($pendingVotes >= $pendingThreshold) {
        $alerts[] = "Pending vote tinggi: {$pendingVotes} (threshold {$pendingThreshold}).";
    }

    if ($failedVotes >= $failedThreshold) {
        $alerts[] = "Failed vote tinggi: {$failedVotes} (threshold {$failedThreshold}).";
    }

    if ($staleProcessing > 0) {
        $alerts[] = "Ada {$staleProcessing} audit log processing stale lebih dari {$staleMinutesThreshold} menit.";
    }

    if ($jobsBacklog !== null && $jobsBacklog >= $queueBacklogThreshold) {
        $alerts[] = "Backlog jobs tinggi: {$jobsBacklog} (threshold {$queueBacklogThreshold}).";
    }

    $payload = [
        'ok' => count($alerts) === 0,
        'generated_at' => now()->toIso8601String(),
        'thresholds' => [
            'pending_votes' => $pendingThreshold,
            'failed_votes' => $failedThreshold,
            'stale_processing_minutes' => $staleMinutesThreshold,
            'queue_backlog' => $queueBacklogThreshold,
        ],
        'metrics' => [
            'pending_votes_total' => $pendingVotes,
            'pending_presma' => $pendingPresma,
            'pending_hima' => $pendingHima,
            'failed_votes_total' => $failedVotes,
            'failed_presma' => $failedPresma,
            'failed_hima' => $failedHima,
            'audit_processing' => $processingCount,
            'audit_pending_queue' => $pendingQueueAuditLogs,
            'audit_failed_total' => $failedAuditLogs,
            'audit_stale_processing' => $staleProcessing,
            'jobs_backlog' => $jobsBacklog,
        ],
        'alerts' => $alerts,
    ];

    if ($this->option('json')) {
        $this->line(json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    } else {
        $rows = [
            ['pending_votes_total', (string) $pendingVotes],
            ['pending_presma', (string) $pendingPresma],
            ['pending_hima', (string) $pendingHima],
            ['failed_votes_total', (string) $failedVotes],
            ['failed_presma', (string) $failedPresma],
            ['failed_hima', (string) $failedHima],
            ['audit_processing', (string) $processingCount],
            ['audit_pending_queue', (string) $pendingQueueAuditLogs],
            ['audit_failed_total', (string) $failedAuditLogs],
            ['audit_stale_processing', (string) $staleProcessing],
            ['jobs_backlog', $jobsBacklog === null ? 'n/a (queue non-database)' : (string) $jobsBacklog],
        ];

        $this->table(['Metric', 'Value'], $rows);

        if (count($alerts) === 0) {
            $this->info('Status monitoring PEMIRA: OK');
        } else {
            $this->warn('Status monitoring PEMIRA: ALERT');
            foreach ($alerts as $alert) {
                $this->warn('- '.$alert);
            }
        }
    }

    if ($this->option('fail-on-alert') && count($alerts) > 0) {
        return 1;
    }

    return 0;
})->purpose('Cek metrik kritis PEMIRA untuk release verification dan monitoring pasca deploy');
