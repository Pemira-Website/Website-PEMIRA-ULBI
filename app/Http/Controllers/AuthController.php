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
        return view('login')->with('title', 'Login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate(
            [
                'npm' => 'required|string',
                'password' => 'required|string',
            ],
            [
                'npm.required' => 'Kolom NPM wajib diisi.',
                'npm.string' => 'NPM harus berupa teks.',
                'password.required' => 'Kolom password wajib diisi.',
                'password.string' => 'Password harus berupa teks.',
            ]
        );

        $npm = $request->input('npm');
        $password = $request->input('password');

        // Cari akun berdasarkan NPM
        $user = Pemilih::where('npm', $npm)->first();

        if ($user && Hash::check($password, $user->password)) {
            // Parse jenis_pemilihan (format: "presma,himatif")
            $allowedVotes = array_map('trim', explode(',', $user->jenis_pemilihan));
            
            // Get hima type (non-presma value)
            $himaType = null;
            foreach ($allowedVotes as $vote) {
                if ($vote !== 'presma') {
                    $himaType = $vote;
                    break;
                }
            }

            // Check special programs (only 1 vote allowed)
            if (in_array($himaType, ['hicomlog', 'himabig', 'himamera']) && $user->total_vote >= 1) {
                return redirect()->back()->withErrors(['error' => 'Anda sudah menggunakan hak suara Anda.']);
            }

            // Check if total_vote sudah mencapai 2
            if ($user->total_vote >= 2) {
                return redirect()->back()->withErrors(['error' => 'Anda sudah menggunakan hak suara Anda.']);
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
        Session::flush();
        return redirect()->route('login');
    }
}
