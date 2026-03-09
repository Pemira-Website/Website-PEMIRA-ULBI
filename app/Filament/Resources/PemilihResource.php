<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PemilihResource\Pages;
use App\Filament\Resources\PemilihResource\RelationManagers;
use App\Models\Pemilih;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Collection;

class PemilihResource extends Resource
{
    protected static ?string $model = Pemilih::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Pemilih')
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('npm')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                // Auto-generate password dari 4 digit terakhir NPM jika password masih kosong
                                if ($state && empty($get('password'))) {
                                    $set('password', substr($state, -4));
                                }
                            }),
                        Forms\Components\Select::make('prodi')
                            ->required()
                            ->searchable()
                            ->options([
                                'D3 Akuntansi'           => 'D3 Akuntansi',
                                'D3 Manajemen Logistik'  => 'D3 Manajemen Logistik',
                                'D3 Manajemen Bisnis'    => 'D3 Manajemen Bisnis',
                                'D3 Manajemen Informatika' => 'D3 Manajemen Informatika',
                                'D3 Teknik Informatika'  => 'D3 Teknik Informatika',
                                'D4 Logistik Bisnis'     => 'D4 Logistik Bisnis',
                                'D4 Akuntansi Keuangan'  => 'D4 Akuntansi Keuangan',
                                'D4 Manajemen Bisnis'    => 'D4 Manajemen Bisnis',
                                'D4 Teknik Informatika'  => 'D4 Teknik Informatika',
                                'D4 E-Commerce Logistics' => 'D4 E-Commerce Logistics',
                                'S1 Manajemen Logistik'  => 'S1 Manajemen Logistik',
                                'S1 Manajemen Transportasi' => 'S1 Manajemen Transportasi',
                                'S1 Sains Data'          => 'S1 Sains Data',
                                'S1 Bisnis Digital'      => 'S1 Bisnis Digital',
                                'S1 Manajemen Rekayasa'  => 'S1 Manajemen Rekayasa',
                            ]),
                        Forms\Components\Select::make('jenis_pemilihan')
                            ->required()
                            ->multiple()
                            ->afterStateHydrated(function ($state, callable $set) {
                                // Konversi comma-separated string ke array untuk form
                                if (is_string($state) && !empty($state)) {
                                    $set('jenis_pemilihan', array_map('trim', explode(',', $state)));
                                }
                            })
                            ->dehydrateStateUsing(function ($state) {
                                // Konversi array kembali ke comma-separated string untuk database
                                if (is_array($state)) {
                                    return implode(',', $state);
                                }
                                return $state;
                            })
                            ->options([
                                'presma'   => 'Presiden Mahasiswa (Presma)',
                                'himatif'  => 'Himpunan - HIMATIF',
                                'himagis'  => 'Himpunan - HIMAGIS',
                                'himalogbis' => 'Himpunan - HIMALOGBIS',
                                'himaporta' => 'Himpunan - HIMAPORTA',
                                'himanbis' => 'Himpunan - HIMANBIS',
                                'hma'      => 'Himpunan - HMA',
                                'himabig'  => 'Himpunan - HIMABIG',
                                'hicomlog' => 'Himpunan - HICOMLOG',
                                'himasta'  => 'Himpunan - HIMASTA',
                                'himamera' => 'Himpunan - HIMAMERA',
                                'hmmi'     => 'Himpunan - HMMI',
                            ]),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Password & Kode')
                    ->description('Password akan otomatis di-generate dari 4 digit terakhir NPM jika dikosongkan')
                    ->schema([
                        Forms\Components\TextInput::make('password')
                            ->label('Password / Kode')
                            ->maxLength(255)
                            ->suffixAction(
                                Forms\Components\Actions\Action::make('generateFromNpm')
                                    ->icon('heroicon-o-key')
                                    ->tooltip('Generate dari 4 digit terakhir NPM')
                                    ->action(function (callable $set, callable $get) {
                                        $npm = $get('npm');
                                        if ($npm) {
                                            $set('password', substr($npm, -4));
                                            Notification::make()
                                                ->title('Password di-generate')
                                                ->body('Password diambil dari 4 digit terakhir NPM')
                                                ->success()
                                                ->send();
                                        }
                                    })
                            ),
                    ])
                    ->columns(1),
                
                Forms\Components\Section::make('Status Voting')
                    ->schema([
                        Forms\Components\Toggle::make('sudah_login')
                            ->default(false),
                        Forms\Components\TextInput::make('total_vote')
                            ->numeric()
                            ->default(0),
                        Forms\Components\TextInput::make('pml_presma')
                            ->label('Suara Presiden Mahasiswa')
                            ->numeric()
                            ->default(0),
                        Forms\Components\TextInput::make('pml_hima')
                            ->label('Suara HIMA')
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('npm')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('NPM disalin!'),
                Tables\Columns\TextColumn::make('password')
                    ->label('Kode')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('prodi')
                    ->searchable()
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('jenis_pemilihan')
                    ->searchable(),
                Tables\Columns\IconColumn::make('sudah_login')
                    ->boolean()
                    ->label('Sudah Login'),
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
                Tables\Columns\TextColumn::make('pml_presma')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('pml_hima')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('prodi')
                    ->options(fn () => Pemilih::distinct()->pluck('prodi', 'prodi')->toArray()),
                Tables\Filters\TernaryFilter::make('sudah_login')
                    ->label('Status Login'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('generateKode')
                        ->label('Generate Kode')
                        ->icon('heroicon-o-key')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Generate Kode untuk Pemilih Ini?')
                        ->modalDescription(fn ($record) => "Password akan di-generate dari 4 digit terakhir NPM ({$record->npm}): " . substr($record->npm, -4))
                        ->action(function ($record) {
                            $password = substr($record->npm, -4);
                            $record->update([
                                'password' => \Illuminate\Support\Facades\Hash::make($password),
                                'otp_expires_at' => \Carbon\Carbon::now('Asia/Jakarta')->addMinutes(30),
                            ]);
                            Notification::make()
                                ->title('Kode berhasil di-generate!')
                                ->body("Password: {$password} (berlaku 30 menit)")
                                ->success()
                                ->send();
                        }),
                    Tables\Actions\Action::make('copyKode')
                        ->label('Salin Kode')
                        ->icon('heroicon-o-clipboard-document')
                        ->color('info')
                        ->action(function ($record) {
                            Notification::make()
                                ->title('Kode: ' . $record->password)
                                ->body('Gunakan Ctrl+C untuk menyalin')
                                ->success()
                                ->send();
                        }),
                ]),
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
            'index' => Pages\ListPemilihs::route('/'),
            'create' => Pages\CreatePemilih::route('/create'),
            'edit' => Pages\EditPemilih::route('/{record}/edit'),
        ];
    }
}
