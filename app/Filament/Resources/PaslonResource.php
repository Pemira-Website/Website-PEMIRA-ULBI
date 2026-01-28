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
                    ->visibility('public')
                    ->required(),
                Forms\Components\TextInput::make('nm_wakil')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('ft_wakil')
                    ->image()
                    ->disk('gcs')
                    ->directory('paslon')
                    ->visibility('public')
                    ->required(),
                Forms\Components\TextInput::make('npm_ketua')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('npm_wakil')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('pd_ketua') // Menjadikan pd_ketua enum
                    ->options([
                        'D3 Teknik Informatika' => 'D3 Teknik Informatika',
                        'D4 Teknik Informatika' => 'D4 Teknik Informatika',
                        'D3 Administrasi Logistik' => 'D3 Administrasi Logistik',
                        'D4 Logistik Bisnis' => 'D4 Logistik Bisnis',
                        'S1 Manajemen Logistik' => 'S1 Manajemen Logistik',
                        'S1 Bisnis Digital' => 'S1 Bisnis Digital',
                        'S1 Sains Data' => 'S1 Sains Data',
                        'S1 Manajemen Rekayasa' => 'S1 Manajemen Rekayasa',
                        'D4 Logistik Niaga-EL' => 'D4 Logistik Niaga-EL',
                        'S1 Manajemen Transportasi' => 'S1 Manajemen Transportasi',
                        'D4 Manajemen Perusahaan' => 'D4 Manajemen Perusahaan',
                        'D3 Manajemen Pemasaran' => 'D3 Manajemen Pemasaran',
                        'D3 Akuntansi' => 'D3 Akuntansi',
                        'D4 Akuntansi Keuangan' => 'D4 Akuntansi Keuangan',
                        'D3 Manajemen informatika' => 'D3 Manajemen informatika'
                    ])
                    ->required(),
                Forms\Components\Select::make('pd_wakil') // Menjadikan pd_wakil enum
                    ->options([
                        'D3 Teknik Informatika' => 'D3 Teknik Informatika',
                        'D4 Teknik Informatika' => 'D4 Teknik Informatika',
                        'D3 Administrasi Logistik' => 'D3 Administrasi Logistik',
                        'D4 Logistik Bisnis' => 'D4 Logistik Bisnis',
                        'S1 Manajemen Logistik' => 'S1 Manajemen Logistik',
                        'S1 Bisnis Digital' => 'S1 Bisnis Digital',
                        'S1 Sains Data' => 'S1 Sains Data',
                        'S1 Manajemen Rekayasa' => 'S1 Manajemen Rekayasa',
                        'D4 Logistik Niaga-EL' => 'D4 Logistik Niaga-EL',
                        'S1 Manajemen Transportasi' => 'S1 Manajemen Transportasi',
                        'D4 Manajemen Perusahaan' => 'D4 Manajemen Perusahaan',
                        'D3 Manajemen Pemasaran' => 'D3 Manajemen Pemasaran',
                        'D3 Akuntansi' => 'D3 Akuntansi',
                        'D4 Akuntansi Keuangan' => 'D4 Akuntansi Keuangan',
                        'D3 Manajemen informatika' => 'D3 Manajemen informatika'
                    ])
                    ->required(),
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
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('jbt_wakil') // Menjadikan jbt_wakil enum
                    ->options([
                        'Wakil Presiden Mahasiswa' => 'Wakil Presiden Mahasiswa',
                        'Wakil Ketua Himpunan' => 'Wakil Ketua Himpunan',
                    ])
                    ->required(),
                Forms\Components\Textarea::make('visi')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('misi')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('jenis_pemilihan') // Menjadikan jenis_pemilihan enum
                    ->options([
                        'himatif' => 'Himatif',
                        'himagis' => 'Himagis',
                        'himalogbis' => 'Himalogbis',
                        'himaporta' => 'Himaporta',
                        'himanbis' => 'Himanbis',
                        'hma' => 'HMA',
                        'himabig' => 'Himabig',
                        'hicomlog' => 'Hicomlog',
                        'himasta' => 'Himasta',
                        'himamera' => 'Himamera',
                        'hmmi' => 'Hmmi',
                        'presma' => 'Presma',
                    ])
                    ->required(),
                    Forms\Components\TextInput::make('total_vote')
                    ->required()
                    ->numeric(),
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
                    ->sortable(),
                Tables\Columns\TextColumn::make('npm_wakil')
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
