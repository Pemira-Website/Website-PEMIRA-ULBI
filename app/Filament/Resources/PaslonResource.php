<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaslonResource\Pages;
use App\Models\Paslon;
use App\Support\PemiraConfig;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;

class PaslonResource extends Resource
{
    protected static ?string $model = Paslon::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

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
                Forms\Components\FileUpload::make('ft_ketua')
                    ->image()
                    ->disk('gcs')
                    ->directory('paslon')
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->maxSize(5120)
                    ->openable()
                    ->downloadable(),
                Forms\Components\TextInput::make('nm_wakil')
                    ->label('Nama Wakil (Opsional)')
                    ->maxLength(255)
                    ->helperText('Kosongkan jika pasangan calon tidak memiliki wakil.'),
                Forms\Components\FileUpload::make('ft_wakil')
                    ->label('Foto Wakil (Opsional)')
                    ->image()
                    ->disk('gcs')
                    ->directory('paslon')
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->maxSize(5120)
                    ->openable()
                    ->downloadable(),
                Forms\Components\TextInput::make('npm_ketua')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('npm_wakil')
                    ->label('NPM Wakil (Opsional)')
                    ->numeric(),
                Forms\Components\Select::make('pd_ketua') // Menjadikan pd_ketua enum
                    ->options(function (): array {
                        $prodis = array_keys(PemiraConfig::prodiToHimaMap());
                        sort($prodis);

                        return array_combine($prodis, $prodis);
                    })
                    ->required(),
                Forms\Components\Select::make('pd_wakil') // Menjadikan pd_wakil enum
                    ->label('Prodi Wakil (Opsional)')
                    ->options(function (): array {
                        $prodis = array_keys(PemiraConfig::prodiToHimaMap());
                        sort($prodis);

                        return array_combine($prodis, $prodis);
                    }),
                Forms\Components\TextInput::make('ang_ketua')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('jbt_ketua') // Menjadikan jbt_ketua enum
                    ->options([
                        'Presiden Mahasiswa' => 'Presiden Mahasiswa',
                        'Ketua Himpunan' => 'Ketua Himpunan',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('ang_wakil')
                    ->label('Angkatan Wakil (Opsional)')
                    ->maxLength(255),
                Forms\Components\Select::make('jbt_wakil') // Menjadikan jbt_wakil enum
                    ->label('Jabatan Wakil (Otomatis / Opsional)')
                    ->options([
                        'Wakil Presiden Mahasiswa' => 'Wakil Presiden Mahasiswa',
                        'Wakil Ketua Himpunan' => 'Wakil Ketua Himpunan',
                    ])
                    ->helperText('Akan diisi otomatis jika data wakil tersedia.'),
                Forms\Components\Textarea::make('visi')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('misi')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('jenis_pemilihan') // Menjadikan jenis_pemilihan enum
                    ->options(PemiraConfig::voteTypes())
                    ->required(),
                Forms\Components\Toggle::make('is_withdrawn')
                    ->label('Paslon Mengundurkan Diri')
                    ->helperText('Jika diaktifkan, slot nomor urut tetap tampil sebagai kotak kosong dan tidak bisa dipilih.')
                    ->default(false),
                Forms\Components\TextInput::make('total_vote')
                    ->label('Total Vote (Sistem)')
                    ->numeric()
                    ->default(0)
                    ->disabled()
                    ->dehydrated(false)
                    ->helperText('Dihitung otomatis oleh sistem voting, tidak bisa diedit manual.'),
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
                Tables\Columns\ImageColumn::make('ft_ketua')
                    ->label('Foto Ketua')
                    ->disk('gcs')
                    ->square()
                    ->size(60),
                Tables\Columns\TextColumn::make('nm_wakil')
                    ->searchable()
                    ->placeholder('-'),
                Tables\Columns\ImageColumn::make('ft_wakil')
                    ->label('Foto Wakil')
                    ->disk('gcs')
                    ->square()
                    ->size(60),
                Tables\Columns\TextColumn::make('npm_ketua')
                    ->sortable(),
                Tables\Columns\TextColumn::make('npm_wakil')
                    ->sortable()
                    ->placeholder('-'),
                Tables\Columns\TextColumn::make('pd_ketua')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pd_wakil')
                    ->searchable()
                    ->placeholder('-'),
                Tables\Columns\TextColumn::make('ang_ketua')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jbt_ketua')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ang_wakil')
                    ->searchable()
                    ->placeholder('-'),
                Tables\Columns\TextColumn::make('jbt_wakil')
                    ->searchable()
                    ->placeholder('-'),
                Tables\Columns\TextColumn::make('jenis_pemilihan')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_withdrawn')
                    ->label('Mundur')
                    ->boolean(),
                Tables\Columns\TextColumn::make('total_vote')
                    ->numeric()
                    ->sortable(),
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
