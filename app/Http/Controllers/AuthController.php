<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Accounts;
use Illuminate\Support\Facades\Session;

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
        $user = Accounts::where('npm', $npm)->first();

        if ($user) {
            // Verifikasi password tanpa hash
            if ($password === $user->password) { // Langsung membandingkan plaintext password
                if ($user->total_vote == 2) {
                    return redirect()->back()->withErrors(['error' => 'Anda sudah menggunakan hak suara anda.']);
                } else {
                    // Simpan informasi ke session
                    Session::put('npm', $user->npm);
                    Session::put('nama', $user->nama);
                    Session::put('prodi', $user->prodi);

                    // Redirect ke halaman utama atau dashboard
                    return redirect()->route('home');
                }
            } else {
                return redirect()->back()->withErrors(['error' => 'Password tidak sesuai!']);
            }
        } else {
            return redirect()->back()->withErrors(['error' => 'NPM tidak sesuai!']);
        }
    }

    public function logout()
    {
        Session::flush();
        return redirect()->route('login');
    }
}
