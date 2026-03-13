<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Paslon;
use App\Support\PemiraConfig;
use Illuminate\Support\Facades\Cache;

class PresmaLiveChart extends Component
{
    public $totalVote;
    public int $pollingSeconds = 10;

    public function mount()
    {
        $this->pollingSeconds = PemiraConfig::resultPollingSeconds();
        $this->loadData();
    }

    public function render()
    {
        return view('livewire.presma-live-chart')
            ->extends('layouts.app')
            ->section('livechart');
    }

    #[On('ubahData')]
    public function changeData()
    {
        $this->loadData();
        $this->dispatch('berhasilUpdate', data: $this->totalVote);
    }

    private function loadData()
    {
        $cacheTtlSeconds = PemiraConfig::resultCacheTtlSeconds();

        $data = Cache::remember('presma_chart_data', $cacheTtlSeconds, function () {
            $totalVote = Paslon::where('jenis_pemilihan', 'presma')->get();
            return [
                'data' => $totalVote->pluck('total_vote')->map(fn($vote) => (int) $vote)->toArray(),
                'total' => $totalVote->sum('total_vote')
            ];
        });

        $this->totalVote = json_encode($data);
    }
}
