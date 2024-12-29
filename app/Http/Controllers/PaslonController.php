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
            'himatif'      => ['D3 Teknik Informatika', 'D4 Teknik Informatika'],
            'himagis'      => ['S1 Manajemen Logistik'],
            'himalogbis'   => ['D3 Administrasi Logistik', 'D4 Logistik Bisnis'],
            'himaporta'    => ['S1 Manajemen Transportasi'],
            'himanbis'     => ['D3 Manajemen Pemasaran' , 'D4 Manajemen Perusahaan'],
            'hma'          => ['D3 Akuntansi', 'D4 Akuntansi Keuangan'],
            'himabig'      => ['S1 Bisnis Digital'],
            'hicomlog'     => ['D4 Logistik Niaga-EL'],
            'himasta'      => ['S1 Sains Data'],
            'himamera'     => ['S1 Manajemen Rekayasa'],
            'hmmi'         => ['D3 Manajemen Informatika'],
            'presma'       => ['Semua Prodi'], // Presma bisa diakses oleh semua prodi
        ];

        // Validasi akses halaman
        if (isset($prodiValidasi[$jenis_pemilihan])) {
            if ($prodiValidasi[$jenis_pemilihan] !== ['Semua Prodi'] && !in_array($userProdi, $prodiValidasi[$jenis_pemilihan])) {
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
