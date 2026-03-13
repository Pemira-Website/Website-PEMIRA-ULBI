<?php

namespace App\Filament\Resources\PemilihResource\Pages;

use App\Filament\Resources\PemilihResource;
use App\Support\PemiraConfig;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Hash;

class EditPemilih extends EditRecord
{
    protected static string $resource = PemilihResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (!empty($data['prodi'])) {
            $data['prodi'] = PemiraConfig::normalizeProdi($data['prodi']);
            $data['jenis_pemilihan'] = implode(',', PemiraConfig::allowedVoteTypesForProdi($data['prodi']));
        }

        if (array_key_exists('password', $data)) {
            if (empty($data['password'])) {
                unset($data['password']);
                return $data;
            }

            $hashInfo = password_get_info((string) $data['password']);
            if (($hashInfo['algo'] ?? null) === null) {
                $data['password'] = Hash::make($data['password']);
            }
        }

        return $data;
    }
}
