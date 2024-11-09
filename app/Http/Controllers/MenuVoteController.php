<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MenuVoteController extends Controller
{
    public function show($prodi)
    {
        // Ambil prodi dari session
        $userProdi = Session::get('prodi');

        // Pastikan user hanya bisa mengakses halaman sesuai prodi mereka
        if ($userProdi !== $prodi) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Kirim prodi ke view
        return view('menu_vote', compact('prodi'));
    }
}

