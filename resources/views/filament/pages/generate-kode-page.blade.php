<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Form Input NPM --}}
        <x-filament-panels::form wire:submit="generateKode">
            {{ $this->form }}

            <div class="flex gap-3 mt-4">
                <x-filament::button type="submit" color="success" icon="heroicon-o-key" size="lg">
                    🎲 Generate Kode OTP
                </x-filament::button>
                
                <x-filament::button type="button" color="gray" icon="heroicon-o-arrow-path" wire:click="resetForm">
                    Reset
                </x-filament::button>
            </div>
        </x-filament-panels::form>

        {{-- Info Box --}}
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
            <div class="flex items-center gap-2 text-blue-800 dark:text-blue-200">
                <x-heroicon-o-information-circle class="w-5 h-5" />
                <span class="text-sm font-medium">Kode OTP: 6 digit alfanumerik (huruf + angka), berlaku selama 30 menit</span>
            </div>
        </div>

        {{-- Hasil Generate --}}
        @if($this->show_result)
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="bg-gray-50 dark:bg-gray-800 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Hasil Generate Kode OTP</h2>
                </div>

                <div class="p-6">
                    @if($this->pemilih_found)
                        {{-- Success State --}}
                        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-6 mb-6">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-green-800 dark:text-green-200">Kode OTP Berhasil Di-generate!</h3>
                                    <p class="text-sm text-green-600 dark:text-green-400">Kode telah disimpan dan berlaku selama 30 menit</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-white dark:bg-gray-800 rounded-lg p-4">
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Nama</p>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $this->result_nama }}</p>
                                </div>
                                <div class="bg-white dark:bg-gray-800 rounded-lg p-4">
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Prodi</p>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $this->result_prodi }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- OTP Code Display - BIG AND VISIBLE --}}
                        <div class="bg-gradient-to-r from-orange-500 to-amber-500 rounded-2xl p-8 shadow-xl text-center">
                            <p class="text-white/80 text-sm mb-3">🔐 KODE OTP ANDA</p>
                            <div class="bg-white rounded-xl p-6 mb-4">
                                <p class="text-6xl md:text-7xl font-bold text-gray-900 font-mono tracking-widest" style="letter-spacing: 0.3em;">
                                    {{ $this->result_kode }}
                                </p>
                            </div>
                            <p class="text-white/70 text-xs">Gunakan kode ini untuk login</p>
                        </div>

                        {{-- Expiration Info --}}
                        <div class="mt-6 bg-yellow-50 dark:bg-yellow-900/30 border border-yellow-300 dark:border-yellow-700 rounded-lg p-4">
                            <div class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-yellow-800 dark:text-yellow-200 font-medium">
                                    Berlaku hingga: <strong>{{ $this->result_expires_at }}</strong> (30 menit)
                                </span>
                            </div>
                            <p class="text-center text-xs text-yellow-600 dark:text-yellow-400 mt-2">
                                ⚠️ Setelah waktu habis, kode tidak bisa digunakan untuk login
                            </p>
                        </div>
                    @else
                        {{-- Error State --}}
                        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-red-500 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-red-800 dark:text-red-200">NPM Tidak Ditemukan!</h3>
                                    <p class="text-sm text-red-600 dark:text-red-400">NPM yang dimasukkan tidak terdaftar dalam sistem. Pastikan NPM sudah benar atau hubungi panitia.</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
</x-filament-panels::page>
