<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemilih;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'npm' => 'required|string',
            'password' => 'required|string',
        ]);

        $npm = $request->input('npm');
        $password = $request->input('password');

        // Cari akun berdasarkan NPM
        $user = Pemilih::where('npm', $npm)->first();

        if ($user && Hash::check($password, $user->password)) { // Verifikasi password dengan hash
            if ($user->total_vote == 2) {
                return redirect()->back()->withErrors(['error' => 'Anda sudah menggunakan hak suara anda.']);
            }

            // Simpan informasi user ke dalam session
            Session::put('npm', $user->npm);
            Session::put('nama', $user->nama);
            Session::put('prodi', $user->prodi);
            Session::put('jenis_pemilihan', $user->jenis_pemilihan);

            // Redirect ke halaman menuvote sesuai prodi
            return redirect()->route('menuvote', ['prodi' => $user->prodi]);
        } else {
            return redirect()->back()->withErrors(['error' => 'NPM atau password tidak sesuai!']);
        }
    }

    public function logout()
    {
        // Hapus session
        Session::flush();
        return redirect()->route('login');
    }
}

