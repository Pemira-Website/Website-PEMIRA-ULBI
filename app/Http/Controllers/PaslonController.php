<?php

namespace App\Http\Controllers;

use App\Models\Paslon;
use Illuminate\Support\Facades\Session;

class PaslonController extends Controller
{
    public function index($jenis_pemilihan)
    {
        if (!Session::has('prodi')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil prodi user dari sesi
        $userProdi = Session::get('prodi');

        // Aturan akses berdasarkan jenis pemilihan dan prodi user
        $prodiValidasi = [
            'himatif' => 'Teknik Informatika',
            'himagis' => 'Manajemen Logistik',
            'presma'  => 'Semua Prodi', // Presma bisa diakses oleh semua prodi
        ];

        // Validasi akses halaman
        if (isset($prodiValidasi[$jenis_pemilihan])) {
            if ($prodiValidasi[$jenis_pemilihan] !== 'Semua Prodi' && $userProdi !== $prodiValidasi[$jenis_pemilihan]) {
                // Redirect dengan pesan error untuk modal
                return redirect()->back()->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            }
        } else {
            return redirect()->back()->with('error', 'Halaman tidak valid.');
        }

        // Ambil data paslon berdasarkan jenis pemilihan
        $dataPaslon = Paslon::where('jenis_pemilihan', $jenis_pemilihan)->get();

        // Kirim data ke view
        return view('vote.paslon', compact('dataPaslon', 'jenis_pemilihan'));
    }
}
