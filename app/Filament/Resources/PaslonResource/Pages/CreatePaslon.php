<?php

namespace App\Filament\Resources\PaslonResource\Pages;

use App\Filament\Resources\PaslonResource;
use App\Support\PemiraConfig;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePaslon extends CreateRecord
{
    protected static string $resource = PaslonResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (!empty($data['pd_ketua'])) {
            $data['pd_ketua'] = PemiraConfig::normalizeProdi($data['pd_ketua']);
        }

        if (!empty($data['pd_wakil'])) {
            $data['pd_wakil'] = PemiraConfig::normalizeProdi($data['pd_wakil']);
        }

        if (($data['jenis_pemilihan'] ?? null) === 'presma') {
            $data['jbt_ketua'] = 'Presiden Mahasiswa';
            $data['jbt_wakil'] = 'Wakil Presiden Mahasiswa';
        } else {
            $data['jbt_ketua'] = 'Ketua Himpunan';
            $data['jbt_wakil'] = 'Wakil Ketua Himpunan';
        }

        $data['total_vote'] = 0;

        return $data;
    }
}
