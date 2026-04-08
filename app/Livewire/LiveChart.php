<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Paslon;
use App\Support\PemiraConfig;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class LiveChart extends Component
{
    public $jenis_pemilihan;
    public $chartDataJson;
    public int $pollingSeconds = 10;

    public function mount($jenis_pemilihan = 'presma')
    {
        $this->jenis_pemilihan = $jenis_pemilihan;
        $this->pollingSeconds = PemiraConfig::resultPollingSeconds();
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
        if (!PemiraConfig::canShowPublicResults()) {
            $this->chartDataJson = json_encode([
                'labels' => [],
                'data' => [],
                'images' => [],
                'colors' => [],
                'borderColors' => [],
                'total' => 0,
            ]);

            return;
        }

        $cacheTtlSeconds = PemiraConfig::resultCacheTtlSeconds();

        $data = Cache::remember("chart_data_{$this->jenis_pemilihan}", $cacheTtlSeconds, function () {
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
                // Formatting numbers to 01, 02 etc.
                $labels[] = str_pad($paslon->paslon_ke, 2, '0', STR_PAD_LEFT);
                $votes[] = (int) $paslon->total_vote;

                $isWithdrawn = (bool) $paslon->is_withdrawn;

                // Slot yang mundur tetap muncul di hasil, tapi tanpa identitas kandidat.
                $ketuaUrl = !$isWithdrawn && filled($paslon->ft_ketua)
                    ? (Str::startsWith($paslon->ft_ketua, 'http') ? $paslon->ft_ketua : \Illuminate\Support\Facades\Storage::disk('gcs')->url($paslon->ft_ketua))
                    : null;
                $wakilUrl = !$isWithdrawn && filled($paslon->ft_wakil)
                    ? (Str::startsWith($paslon->ft_wakil, 'http') ? $paslon->ft_wakil : \Illuminate\Support\Facades\Storage::disk('gcs')->url($paslon->ft_wakil))
                    : null;

                $images[] = [
                    'ketua' => $ketuaUrl,
                    'wakil' => $wakilUrl,
                    'has_wakil' => !$isWithdrawn && filled($paslon->nm_wakil),
                ];

                if ($isWithdrawn) {
                    $colors[] = 'rgba(148, 163, 184, 0.85)';
                    $borderColors[] = 'rgb(100, 116, 139)';
                    continue;
                }

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
