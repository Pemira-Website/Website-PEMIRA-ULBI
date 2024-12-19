<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaslonResource\Pages;
use App\Models\Paslon;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;

class PaslonResource extends Resource
{
    protected static ?string $model = Paslon::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('paslon_ke')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('nm_ketua')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('ft_ketua') // Kolom untuk upload foto ketua
                    ->image()
                    ->directory('fotoPaslon')
                    ->required(),
                Forms\Components\TextInput::make('nm_wakil')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('ft_wakil') // Kolom untuk upload foto wakil
                    ->image()
                    ->directory('fotoPaslon')
                    ->required(),
                Forms\Components\TextInput::make('npm_ketua')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('npm_wakil')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('pd_ketua')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('pd_wakil')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('ang_ketua')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('jbt_ketua')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('ang_wakil')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('jbt_wakil')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('visi')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('misi')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('jenis_pemilihan')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('paslon_ke')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nm_ketua')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('ft_ketua') // Kolom gambar ketua
                    ->label('Foto Ketua'),
                Tables\Columns\TextColumn::make('nm_wakil')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('ft_wakil') // Kolom gambar wakil
                    ->label('Foto Wakil'),
                Tables\Columns\TextColumn::make('npm_ketua')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('npm_wakil')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pd_ketua')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pd_wakil')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ang_ketua')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jbt_ketua')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ang_wakil')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jbt_wakil')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenis_pemilihan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListPaslons::route('/'),
            'create' => Pages\CreatePaslon::route('/create'),
            'edit' => Pages\EditPaslon::route('/{record}/edit'),
        ];
    }
}
