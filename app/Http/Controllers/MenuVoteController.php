<?php

namespace App\Http\Controllers;

use App\Models\Paslon;
use App\Models\Pemilih;
use App\Support\PemiraConfig;
use Illuminate\Support\Facades\Session;

class MenuVoteController extends Controller
{
    public function show($prodi)
    {
        // Ambil prodi dari session dan normalisasi agar konsisten
        $userProdi = PemiraConfig::normalizeProdi(Session::get('prodi'));
        $routeProdi = PemiraConfig::normalizeProdi($prodi);

        // Validasi: Pastikan user sudah login dan memiliki prodi
        if (!$userProdi) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Validasi: Pastikan user hanya bisa mengakses halaman sesuai prodi mereka
        if ($userProdi !== $routeProdi) {
            return redirect()->route('menuvote', ['prodi' => $userProdi])
                ->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $npmPemilih = Session::get('npm');
        $pemilih = Pemilih::where('npm', $npmPemilih)->first();

        if (!$pemilih) {
            Session::flush();
            return redirect()->route('login')->with('error', 'Data pemilih tidak ditemukan. Silakan login ulang.');
        }

        $presmaStatus = $pemilih->presma_status ?: ($pemilih->pml_presma ? Pemilih::STATUS_COMPLETED : Pemilih::STATUS_NOT_VOTED);
        $himaStatus = $pemilih->hima_status ?: ($pemilih->pml_hima ? Pemilih::STATUS_COMPLETED : Pemilih::STATUS_NOT_VOTED);

        $himaType = PemiraConfig::himaForProdi($userProdi);
        $showHima = filled($himaType) && Paslon::where('jenis_pemilihan', $himaType)->exists();

        // Kirim prodi ke view
        return view('menu_vote', [
            'prodi' => $userProdi,
            'hima_type' => $himaType,
            'show_hima' => $showHima,
            'presma_status' => $presmaStatus,
            'hima_status' => $himaStatus,
            'pml_presma' => Pemilih::isLockedVoteStatus($presmaStatus) ? 1 : 0,
            'pml_hima' => Pemilih::isLockedVoteStatus($himaStatus) ? 1 : 0,
        ])->with('title', 'Prodi ' . $userProdi);
    }
}
