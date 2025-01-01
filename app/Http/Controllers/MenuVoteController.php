<?php

namespace App\Http\Controllers;

use App\Models\Pemilih;
use Illuminate\Support\Facades\Session;

class MenuVoteController extends Controller
{
    public function show($prodi)
    {
        // Ambil prodi dari session
        $userProdi = Session::get('prodi');

        // Validasi: Pastikan user sudah login dan memiliki prodi
        if (!$userProdi) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Validasi: Pastikan user hanya bisa mengakses halaman sesuai prodi mereka
        if ($userProdi !== $prodi) {
            return redirect()->route('menuvote', ['prodi' => $userProdi])
                ->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        $npmPemilih = Session::get('npm');
        $pemilih = Pemilih::where('npm', $npmPemilih)->first();

        // Kirim prodi ke view
        return view('menu_vote', [
            'prodi' => $prodi,
            'pml_presma' => $pemilih->pml_presma ?? 0,
            'pml_hima' => $pemilih->pml_hima ?? 0,
        ])->with('title', 'Prodi ' . $prodi);
    }
}
