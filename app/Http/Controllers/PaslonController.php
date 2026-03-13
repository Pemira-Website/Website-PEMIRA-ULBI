<?php

namespace App\Http\Controllers;

use App\Models\Paslon;
use App\Models\Pemilih;
use App\Support\PemiraConfig;
use Illuminate\Support\Facades\Session;

class PaslonController extends Controller
{
    public function index($jenis_pemilihan)
    {
        if (!Session::has('prodi') || !Session::has('npm')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $userProdi = PemiraConfig::normalizeProdi(Session::get('prodi'));
        if (!$userProdi) {
            Session::flush();
            return redirect()->route('login')->with('error', 'Sesi tidak valid. Silakan login ulang.');
        }

        $pemilih = Pemilih::where('npm', Session::get('npm'))->first();
        if (!$pemilih) {
            Session::flush();
            return redirect()->route('login')->with('error', 'Data pemilih tidak ditemukan. Silakan login ulang.');
        }

        $voteTypes = array_keys(PemiraConfig::voteTypes());
        if (!in_array($jenis_pemilihan, $voteTypes, true)) {
            return redirect()->route('menuvote', ['prodi' => $userProdi])
                ->with('error', 'Jenis pemilihan tidak tersedia.');
        }

        // Presma bisa diakses semua prodi
        if ($jenis_pemilihan !== 'presma') {
            $allowedProdi = PemiraConfig::prodisForHima($jenis_pemilihan);
            if (!in_array($userProdi, $allowedProdi, true)) {
                return redirect()->route('menuvote', ['prodi' => $userProdi])
                    ->with('error', 'Anda tidak memiliki akses ke jenis pemilihan ini.');
            }
        }

        $presmaStatus = $pemilih->presma_status ?: ($pemilih->pml_presma ? Pemilih::STATUS_COMPLETED : Pemilih::STATUS_NOT_VOTED);
        $himaStatus = $pemilih->hima_status ?: ($pemilih->pml_hima ? Pemilih::STATUS_COMPLETED : Pemilih::STATUS_NOT_VOTED);

        if ($jenis_pemilihan === 'presma' && Pemilih::isLockedVoteStatus($presmaStatus)) {
            $message = $presmaStatus === Pemilih::STATUS_PENDING
                ? 'Vote Presma Anda sedang diproses. Tunggu beberapa saat lalu cek status di menu utama.'
                : 'Anda sudah menggunakan hak suara Presma.';

            return redirect()->route('menuvote', ['prodi' => $userProdi])->with('error', $message);
        }

        if ($jenis_pemilihan !== 'presma' && Pemilih::isLockedVoteStatus($himaStatus)) {
            $message = $himaStatus === Pemilih::STATUS_PENDING
                ? 'Vote HIMA Anda sedang diproses. Tunggu beberapa saat lalu cek status di menu utama.'
                : 'Anda sudah menggunakan hak suara HIMA.';

            return redirect()->route('menuvote', ['prodi' => $userProdi])->with('error', $message);
        }

        // Ambil data paslon berdasarkan jenis pemilihan
        $dataPaslon = Paslon::where('jenis_pemilihan', $jenis_pemilihan)->get();

        return view('vote.paslon', compact('dataPaslon', 'jenis_pemilihan', 'userProdi'))
            ->with('title', 'Pemilihan ' . ucwords($jenis_pemilihan));
    }
}
