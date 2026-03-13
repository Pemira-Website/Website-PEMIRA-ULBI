<?php

namespace App\Filament\Resources\PemilihResource\Pages;

use App\Filament\Resources\PemilihResource;
use App\Support\PemiraConfig;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreatePemilih extends CreateRecord
{
    protected static string $resource = PemilihResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (!empty($data['prodi'])) {
            $data['prodi'] = PemiraConfig::normalizeProdi($data['prodi']);
            $data['jenis_pemilihan'] = implode(',', PemiraConfig::allowedVoteTypesForProdi($data['prodi']));
        }

        if (empty($data['password'])) {
            $data['password'] = null;
            return $data;
        }

        $hashInfo = password_get_info((string) $data['password']);
        if (($hashInfo['algo'] ?? null) === null) {
            $data['password'] = Hash::make($data['password']);
        }

        return $data;
    }
}
