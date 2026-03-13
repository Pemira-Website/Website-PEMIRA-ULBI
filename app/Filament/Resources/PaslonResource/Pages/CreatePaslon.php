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
        $data = $this->normalizeWakilData($data);

        if (!empty($data['pd_ketua'])) {
            $data['pd_ketua'] = PemiraConfig::normalizeProdi($data['pd_ketua']);
        }

        if (!empty($data['pd_wakil'])) {
            $data['pd_wakil'] = PemiraConfig::normalizeProdi($data['pd_wakil']);
        }

        if (($data['jenis_pemilihan'] ?? null) === 'presma') {
            $data['jbt_ketua'] = 'Presiden Mahasiswa';
            $data['jbt_wakil'] = !empty($data['nm_wakil']) ? 'Wakil Presiden Mahasiswa' : null;
        } else {
            $data['jbt_ketua'] = 'Ketua Himpunan';
            $data['jbt_wakil'] = !empty($data['nm_wakil']) ? 'Wakil Ketua Himpunan' : null;
        }

        $data['total_vote'] = 0;

        return $data;
    }

    private function normalizeWakilData(array $data): array
    {
        $wakilFields = ['nm_wakil', 'ft_wakil', 'npm_wakil', 'pd_wakil', 'ang_wakil', 'jbt_wakil'];

        foreach ($wakilFields as $field) {
            if (array_key_exists($field, $data) && $data[$field] === '') {
                $data[$field] = null;
            }
        }

        if (empty($data['nm_wakil'])) {
            foreach ($wakilFields as $field) {
                $data[$field] = null;
            }
        }

        return $data;
    }
}
