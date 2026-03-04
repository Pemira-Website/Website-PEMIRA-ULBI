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

    /**
     * Create a new job instance.
     */
    public function __construct($pemilih_id, $paslon_id, $jenisVote, $himaType)
    {
        $this->pemilih_id = $pemilih_id;
        $this->paslon_id = $paslon_id;
        $this->jenisVote = $jenisVote;
        $this->himaType = $himaType;
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

        // Special handling for himabig, hicomlog, and himamera (only presma)
        if (in_array($this->himaType, ['himabig', 'hicomlog', 'himamera'])) {
            if ($this->jenisVote == 'presma') {
                if ($pemilih->pml_presma == 0) {
                    $pemilih->pml_presma = 1;
                    $pemilih->total_vote = 1;
                    $pemilih->save();
                    
                    $paslon->increment('total_vote');
                }
            }
            return;
        }

        // Regular voting logic
        if ($this->jenisVote == 'presma') {
            if ($pemilih->pml_presma == 0) {
                $pemilih->pml_presma = 1;
                $pemilih->total_vote = $pemilih->pml_presma + $pemilih->pml_hima;
                $pemilih->save();
                $paslon->increment('total_vote');
            }
        } elseif ($this->jenisVote == $this->himaType) {
            if ($pemilih->pml_hima == 0) {
                $pemilih->pml_hima = 1;
                $pemilih->total_vote = $pemilih->pml_presma + $pemilih->pml_hima;
                $pemilih->save();
                $paslon->increment('total_vote');
            }
        }
    }
}
