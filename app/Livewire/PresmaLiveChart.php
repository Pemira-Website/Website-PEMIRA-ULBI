<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Accounts;

class PresmaLiveChart extends Component
{
    public $totalVote;

    public function mount()
    {
        $this->loadData();
    }

    public function render()
    {
        return view('livewire.presma-live-chart')
            ->extends('layouts.app')
            ->section('content');
    }

    #[On('ubahData')]
    public function changeData()
    {
        $this->loadData();
        $this->dispatch('berhasilUpdate', data: $this->totalVote);
    }

    private function loadData()
    {
        $totalVote = Accounts::all();
        $data = [
            'data' => $totalVote->pluck('total_vote')->map(fn($vote) => (int) $vote)->toArray(),
            'total' => $totalVote->sum('total_vote') // Menambahkan total suara
        ];
        $this->totalVote = json_encode($data);
    }
}
