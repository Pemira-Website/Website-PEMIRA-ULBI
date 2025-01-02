<?php

namespace App\Http\Controllers;

use App\Models\Pemilih;
use App\Models\Paslon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    /**
     * Tambahkan vote pada akun tertentu.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addVote(Request $request, $npm)
    {
        $pemilih = Pemilih::where('npm', $npm)->first();
        $paslon = Paslon::find($request->input('paslon_id')); // Ambil ID paslon dari request
        $jenisPemilihan = Session::get('jenis_pemilihan');

        // Tambah vote untuk jenis pemilihan
        if ($request->input('jenis_vote') == 'presma' && $pemilih->pml_presma == 0) {
            $pemilih->increment('pml_presma');
            $pemilih->increment('total_vote');
            $paslon->increment('total_vote');
        } elseif ($request->input('jenis_vote') == $jenisPemilihan && $pemilih->pml_hima == 0) {
            $pemilih->increment('pml_hima');
            $pemilih->increment('total_vote');
            $paslon->increment('total_vote');
        } else {
            return redirect()->back()->with('error', 'Anda sudah memberikan vote.');
        }
        
        $user = Session::get('prodi');

        // Cek total_vote
        if ($pemilih->total_vote >= 2) {
            // Logout dan redirect ke halaman logout
            Auth::logout();
            return redirect()->route('logout'); // Ganti 'logout' dengan route yang sesuai
        } else {
            // Redirect ke halaman menuvote
            return redirect()->route('menuvote', ['prodi' => $user])->with('success', 'Vote berhasil ditambahkan.');
        }
    }
}
