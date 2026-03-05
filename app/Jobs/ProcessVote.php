<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessVote implements ShouldQueue
{
    use Queueable;

    public $pemilih_id;
    public $paslon_id;
    public $jenisVote;
    public $himaType;
    public $ip_address;
    public $user_agent;

    /**
     * Create a new job instance.
     */
    public function __construct($pemilih_id, $paslon_id, $jenisVote, $himaType, $ip_address = null, $user_agent = null)
    {
        $this->pemilih_id = $pemilih_id;
        $this->paslon_id = $paslon_id;
        $this->jenisVote = $jenisVote;
        $this->himaType = $himaType;
        $this->ip_address = $ip_address;
        $this->user_agent = $user_agent;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $pemilih = \App\Models\Pemilih::find($this->pemilih_id);
        $paslon = \App\Models\Paslon::find($this->paslon_id);

        if (!$pemilih || !$paslon) {
            return;
        }

        // Create initial AuditLog record
        $auditLog = \App\Models\AuditLog::create([
            'npm' => $pemilih->npm,
            'target_paslon_id' => $paslon->id,
            'jenis_vote' => $this->jenisVote,
            'ip_address' => $this->ip_address,
            'user_agent' => $this->user_agent,
            'status' => 'processing',
        ]);

        // Gunakan Redis Atomic Lock untuk memblokir race condition (double vote).
        // Blokir vote yang terjadi secara bersamaan untuk pemilih_id yang sama ke jenis vote yang sama selama 5 detik.
        $lock = \Illuminate\Support\Facades\Cache::lock("vote_{$this->pemilih_id}_{$this->jenisVote}", 5);

        if ($lock->get()) {
            try {
                \Illuminate\Support\Facades\DB::transaction(function () use ($pemilih, $paslon, $auditLog) {
                    $success = false;

                    // Special handling for himabig, hicomlog, and himamera (only presma)
                    if (in_array($this->himaType, ['himabig', 'hicomlog', 'himamera'])) {
                        if ($this->jenisVote == 'presma' && $pemilih->pml_presma == 0) {
                            $pemilih->pml_presma = 1;
                            $pemilih->total_vote = 1;
                            $pemilih->save();
                            $paslon->increment('total_vote');
                            $success = true;
                        }
                    } else {
                        // Regular voting logic
                        if ($this->jenisVote == 'presma' && $pemilih->pml_presma == 0) {
                            $pemilih->pml_presma = 1;
                            $pemilih->total_vote = $pemilih->pml_presma + $pemilih->pml_hima;
                            $pemilih->save();
                            $paslon->increment('total_vote');
                            $success = true;
                        } elseif ($this->jenisVote == $this->himaType && $pemilih->pml_hima == 0) {
                            $pemilih->pml_hima = 1;
                            $pemilih->total_vote = $pemilih->pml_presma + $pemilih->pml_hima;
                            $pemilih->save();
                            $paslon->increment('total_vote');
                            $success = true;
                        }
                    }

                    if ($success) {
                        $auditLog->update(['status' => 'success']);
                    } else {
                        $auditLog->update(['status' => 'failed_already_voted']);
                    }
                });
            } catch (\Exception $e) {
                $auditLog->update(['status' => 'failed_exception']);
                throw $e;
            } finally {
                $lock->release();
            }
        } else {
            $auditLog->update(['status' => 'failed_race_condition']);
        }
    }
}
