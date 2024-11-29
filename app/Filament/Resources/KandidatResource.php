<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KandidatResource\Pages;
use App\Filament\Resources\KandidatResource\RelationManagers;
use App\Models\Kandidat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KandidatResource extends Resource
{
    protected static ?string $model = Kandidat::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKandidats::route('/'),
            'create' => Pages\CreateKandidat::route('/create'),
            'edit' => Pages\EditKandidat::route('/{record}/edit'),
        ];
    }
}
