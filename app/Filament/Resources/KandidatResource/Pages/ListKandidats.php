<?php

namespace App\Filament\Resources\KandidatResource\Pages;

use App\Filament\Resources\KandidatResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKandidats extends ListRecords
{
    protected static string $resource = KandidatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
