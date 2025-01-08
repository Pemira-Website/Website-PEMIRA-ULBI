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
    $user = Session::get('prodi');

    // Tambah vote untuk jenis pemilihan
    if ($request->input('jenis_vote') == 'presma') {
        if ($pemilih->pml_presma == 0) {
            $pemilih->increment('pml_presma');
            $pemilih->increment('total_vote');
            $paslon->increment('total_vote');
        } else {
            return redirect()->route('menuvote', ['prodi' => $user])
                ->with('error', 'Anda sudah memberikan vote untuk Presma.');
        }
    } elseif ($request->input('jenis_vote') == $jenisPemilihan) {
        if ($pemilih->pml_hima == 0) {
            $pemilih->increment('pml_hima');
            $pemilih->increment('total_vote');
            $paslon->increment('total_vote');
        } else {
            return redirect()->route('menuvote', ['prodi' => $user])
                ->with('error', 'Anda sudah memberikan vote untuk Hima.');
        }
    } else {
        return redirect()->back()->with('error', 'Jenis vote tidak valid.');
    }

    // Cek kondisi khusus untuk jenis pemilihan hicomlog, himabig, himalogbis
    if (in_array($jenisPemilihan, ['hicomlog', 'himabig', 'himamera']) && $pemilih->total_vote == 1) {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Terima kasih, Anda telah memberikan vote.');
    }

    // Cek total_vote setelah pemrosesan
    if ($pemilih->total_vote >= 2) {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Terima kasih, Anda telah memberikan vote.'); // Redirect ke halaman logout jika total vote sudah 2
    } else {
        return redirect()->route('menuvote', ['prodi' => $user])
            ->with('success', 'Vote berhasil ditambahkan.');
    }
}

}
