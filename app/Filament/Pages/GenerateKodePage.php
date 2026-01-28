<?php

namespace App\Filament\Pages;

use App\Models\Pemilih;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class GenerateKodePage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-key';
    protected static ?string $navigationLabel = 'Generate Kode OTP';
    protected static ?string $title = 'Generate Kode OTP';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?int $navigationSort = 10;

    protected static string $view = 'filament.pages.generate-kode-page';

    // Form state
    public ?string $npm = '';
    
    // Result state
    public ?string $result_nama = null;
    public ?string $result_prodi = null;
    public ?string $result_kode = null;
    public ?string $result_expires_at = null;
    public ?int $result_minutes_left = null;
    public bool $show_result = false;
    public bool $pemilih_found = false;

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Generate Kode OTP')
                    ->description('Masukkan NPM untuk generate kode OTP (6 digit alfanumerik, berlaku 30 menit)')
                    ->schema([
                        TextInput::make('npm')
                            ->label('Nomor Pokok Mahasiswa (NPM)')
                            ->placeholder('Contoh: 41522010001')
                            ->required()
                            ->maxLength(20)
                            ->autocomplete(false)
                            ->autofocus(),
                    ])
                    ->columns(1),
            ])
            ->statePath('data');
    }

    public ?array $data = [];

    /**
     * Generate random alphanumeric OTP code (6 digits)
     */
    protected function generateOTP(): string
    {
        // Alphanumeric: Letters + Numbers (exclude confusing chars like 0, O, I, 1, L)
        $characters = 'ABCDEFGHJKMNPQRSTUVWXYZ23456789';
        
        $code = '';
        $max = strlen($characters) - 1;
        
        for ($i = 0; $i < 6; $i++) {
            $code .= $characters[random_int(0, $max)];
        }

        return $code;
    }

    public function generateKode(): void
    {
        $data = $this->form->getState();
        $npm = $data['npm'] ?? '';

        if (empty($npm)) {
            Notification::make()
                ->title('NPM tidak boleh kosong!')
                ->danger()
                ->send();
            return;
        }

        // Cari pemilih berdasarkan NPM
        $pemilih = Pemilih::where('npm', $npm)->first();

        if (!$pemilih) {
            $this->show_result = true;
            $this->pemilih_found = false;
            $this->result_nama = null;
            $this->result_prodi = null;
            $this->result_kode = null;
            $this->result_expires_at = null;
            $this->result_minutes_left = null;

            Notification::make()
                ->title('NPM tidak ditemukan!')
                ->body("NPM {$npm} tidak terdaftar dalam sistem.")
                ->danger()
                ->send();
            return;
        }

        // Generate random alphanumeric OTP (6 digits)
        $kode = $this->generateOTP();
        
        // Set expiration time (30 minutes from now) in WIB timezone
        $expiresAt = Carbon::now('Asia/Jakarta')->addMinutes(30);

        // Update password (hashed) dan expiration di database
        $pemilih->update([
            'password' => Hash::make($kode), // Hash the OTP before saving
            'otp_expires_at' => $expiresAt,
        ]);

        // Set hasil untuk ditampilkan
        $this->show_result = true;
        $this->pemilih_found = true;
        $this->result_nama = $pemilih->nama;
        $this->result_prodi = $pemilih->prodi;
        $this->result_kode = $kode;
        $this->result_expires_at = $expiresAt->format('H:i:s') . ' WIB';
        $this->result_minutes_left = 30;

        Notification::make()
            ->title('Kode OTP berhasil di-generate!')
            ->body("Kode untuk {$pemilih->nama}: {$kode}\nBerlaku hingga: {$expiresAt->format('H:i:s')}")
            ->success()
            ->send();
    }

    public function resetForm(): void
    {
        $this->form->fill([
            'npm' => '',
        ]);
        
        $this->show_result = false;
        $this->pemilih_found = false;
        $this->result_nama = null;
        $this->result_prodi = null;
        $this->result_kode = null;
        $this->result_expires_at = null;
        $this->result_minutes_left = null;
    }
}
