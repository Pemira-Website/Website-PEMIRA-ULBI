<?php

namespace App\Http\Controllers;

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

        // Kirim prodi ke view
        return view('menu_vote', compact('prodi'));
    }
}
