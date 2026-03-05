<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Paslon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class LiveChart extends Component
{
    public $jenis_pemilihan;
    public $chartDataJson;

    public function mount($jenis_pemilihan = 'presma')
    {
        $this->jenis_pemilihan = $jenis_pemilihan;
        $this->loadData();
    }

    public function render()
    {
        return view('livewire.live-chart');
    }

    #[On('ubahData')]
    public function changeData()
    {
        $this->loadData();
        // Fire custom event name so multiple charts in 1 page don't clash
        $this->dispatch('berhasilUpdate-' . $this->jenis_pemilihan, data: $this->chartDataJson);
    }

    private function loadData()
    {
        $data = Cache::remember("chart_data_{$this->jenis_pemilihan}", 5, function () {
            $paslons = Paslon::where('jenis_pemilihan', $this->jenis_pemilihan)->orderBy('paslon_ke', 'asc')->get();
            
            $labels = [];
            $votes = [];
            $images = [];
            $colors = [];
            $borderColors = [];
            
            // Preset color palette to allow up to 6+ paslons seamlessly
            $colorPalette = [
                ['rgba(75, 192, 192, 0.8)', 'rgb(75, 192, 192)'],
                ['rgba(255, 99, 132, 0.8)', 'rgb(255, 99, 132)'],
                ['rgba(54, 162, 235, 0.8)', 'rgb(54, 162, 235)'],
                ['rgba(255, 206, 86, 0.8)', 'rgb(255, 206, 86)'],
                ['rgba(153, 102, 255, 0.8)', 'rgb(153, 102, 255)'],
                ['rgba(255, 159, 64, 0.8)', 'rgb(255, 159, 64)']
            ];

            foreach ($paslons as $index => $paslon) {
                // Ensure labels and votes are captured
                $labels[] = "Paslon " . $paslon->paslon_ke;
                $votes[] = (int) $paslon->total_vote;
                
                // Get the image path properly
                $imgUrl = Str::startsWith($paslon->ft_ketua, 'http') ? $paslon->ft_ketua : asset('storage/' . $paslon->ft_ketua);
                $images[] = $imgUrl;
                
                $colorIndex = $index % count($colorPalette);
                $colors[] = $colorPalette[$colorIndex][0];
                $borderColors[] = $colorPalette[$colorIndex][1];
            }

            return [
                'labels' => $labels,
                'data' => $votes,
                'images' => $images,
                'colors' => $colors,
                'borderColors' => $borderColors,
                'total' => $paslons->sum('total_vote')
            ];
        });

        $this->chartDataJson = json_encode($data);
    }
}

