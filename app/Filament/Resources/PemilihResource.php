<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PemilihResource\Pages;
use App\Filament\Resources\PemilihResource\RelationManagers;
use App\Models\Pemilih;
use App\Support\PemiraConfig;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;

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
                            ->maxLength(20)
                            ->regex('/^[0-9]+$/')
                            ->unique(ignoreRecord: true),
                        Forms\Components\Select::make('prodi')
                            ->required()
                            ->searchable()
                            ->options(function (): array {
                                $prodis = array_keys(PemiraConfig::prodiToHimaMap());
                                sort($prodis);

                                return array_combine($prodis, $prodis);
                            })
                            ->afterStateUpdated(function ($state, callable $set) {
                                $normalizedProdi = PemiraConfig::normalizeProdi($state);
                                if (!$normalizedProdi) {
                                    return;
                                }

                                $set('prodi', $normalizedProdi);
                                $set('jenis_pemilihan', PemiraConfig::allowedVoteTypesForProdi($normalizedProdi));
                            }),
                        Forms\Components\Select::make('jenis_pemilihan')
                            ->required()
                            ->multiple()
                            ->helperText('Jenis pemilihan mengikuti prodi terpilih.')
                            ->options(function (callable $get): array {
                                $normalizedProdi = PemiraConfig::normalizeProdi($get('prodi'));
                                $allowedVoteTypes = PemiraConfig::allowedVoteTypesForProdi($normalizedProdi);
                                $voteLabels = PemiraConfig::voteTypes();

                                return array_intersect_key($voteLabels, array_flip($allowedVoteTypes));
                            })
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
                            }),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Password & Kode')
                    ->description('Kode OTP manual bersifat opsional. Untuk distribusi massal, gunakan halaman "Generate Kode OTP".')
                    ->schema([
                        Forms\Components\TextInput::make('password')
                            ->label('Kode OTP (Opsional)')
                            ->password()
                            ->revealable()
                            ->autocomplete('new-password')
                            ->dehydrated(fn (?string $state): bool => filled($state))
                            ->afterStateHydrated(function (callable $set): void {
                                $set('password', null);
                            })
                            ->maxLength(255)
                            ->suffixAction(
                                Forms\Components\Actions\Action::make('generateOtp')
                                    ->icon('heroicon-o-key')
                                    ->tooltip('Generate OTP acak 6 karakter')
                                    ->action(function (callable $set) {
                                        $otp = PemiraConfig::generateOtpCode();
                                        $set('password', $otp);
                                        Notification::make()
                                            ->title('OTP berhasil di-generate')
                                            ->body("OTP: {$otp}")
                                            ->success()
                                            ->send();
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
                Tables\Columns\TextColumn::make('prodi')
                    ->searchable()
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('jenis_pemilihan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('otp_expires_at')
                    ->label('OTP Exp')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
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
                    ->options(function (): array {
                        $prodis = array_keys(PemiraConfig::prodiToHimaMap());
                        sort($prodis);

                        return array_combine($prodis, $prodis);
                    }),
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
                        ->modalDescription('Sistem akan membuat OTP acak 6 karakter dengan masa berlaku 30 menit.')
                        ->action(function ($record) {
                            $otp = PemiraConfig::generateOtpCode();
                            $record->update([
                                'password' => Hash::make($otp),
                                'otp_expires_at' => now()->addMinutes(30),
                            ]);
                            Notification::make()
                                ->title('Kode berhasil di-generate!')
                                ->body("OTP: {$otp} (berlaku 30 menit)")
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
