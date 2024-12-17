<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class PaslonPresmaController extends Controller
{
    public function presma($prodi)
    {
        // Ambil data prodi dari sesi user yang login
        $himaProdi = Session::get('prodi');

        // Validasi prodi di route sesuai dengan prodi user di sesi
        if ($prodi === $himaProdi) {
            return view('vote.paslon', compact('prodi'));
        } else {
            // Redirect jika prodi tidak sesuai
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
    }
}
