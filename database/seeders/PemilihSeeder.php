<?php

namespace Database\Seeders;

use App\Models\Pemilih;
use App\Support\PemiraConfig;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PemilihSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mapping prodi ke himpunan dari config canonical
        $prodiList = PemiraConfig::prodiToHimaMap();

        $namaDepan = ['Andi', 'Budi', 'Citra', 'Dewi', 'Eko', 'Fitri', 'Galih', 'Hana', 'Irfan', 'Joko', 'Kartika', 'Lina', 'Maya', 'Nanda', 'Omar', 'Putri', 'Qori', 'Rina', 'Sari', 'Tono', 'Umar', 'Vina', 'Wati', 'Xena', 'Yudi', 'Zahra'];
        $namaBelakang = ['Pratama', 'Wijaya', 'Saputra', 'Kusuma', 'Hidayat', 'Putra', 'Permana', 'Setiawan', 'Ramadhani', 'Nugraha', 'Santoso', 'Wibowo', 'Hartono', 'Susanto', 'Gunawan'];

        $counter = 1;
        $created = 0;

        foreach ($prodiList as $prodi => $hima) {
            // Generate 10 pemilih per prodi
            for ($i = 0; $i < 10; $i++) {
                $npm = '21' . str_pad($counter, 6, '0', STR_PAD_LEFT);
                $nama = $namaDepan[array_rand($namaDepan)] . ' ' . $namaBelakang[array_rand($namaBelakang)];
                
                $allowedVoteTypes = PemiraConfig::allowedVoteTypesForProdi($prodi);
                $jenisPemilihan = implode(',', $allowedVoteTypes);
                
                // Password = NPM (untuk testing, mudah diingat)
                Pemilih::updateOrCreate(
                    ['npm' => $npm],
                    [
                        'nama' => $nama,
                        'prodi' => $prodi,
                        'password' => Hash::make($npm), // Password = NPM
                        'jenis_pemilihan' => $jenisPemilihan,
                        'sudah_login' => false,
                        'total_vote' => 0,
                        'pml_presma' => 0,
                        'presma_status' => Pemilih::STATUS_NOT_VOTED,
                        'pml_hima' => 0,
                        'hima_status' => Pemilih::STATUS_NOT_VOTED,
                    ]
                );
                
                $counter++;
                $created++;
            }
        }

        $this->command->info('✅ Created/Updated ' . $created . ' pemilih records');
        $this->command->info('� Password = NPM (contoh: NPM 21000001, Password 21000001)');
    }
}
