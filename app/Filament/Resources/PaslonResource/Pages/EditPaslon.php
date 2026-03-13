<?php

namespace App\Filament\Resources\PaslonResource\Pages;

use App\Filament\Resources\PaslonResource;
use App\Support\PemiraConfig;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPaslon extends EditRecord
{
    protected static string $resource = PaslonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
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

        unset($data['total_vote']);

        return $data;
    }
}
