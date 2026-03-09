<?php

namespace App\Filament\Resources\PemilihResource\Pages;

use App\Filament\Resources\PemilihResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePemilih extends CreateRecord
{
    protected static string $resource = PemilihResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Jika password dikosongkan, simpan sebagai null (bukan string kosong)
        if (empty($data['password'])) {
            $data['password'] = null;
        }
        
        return $data;
    }
}
