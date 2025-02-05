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
     * Tambahkan atau hapus vote pada akun tertentu.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $npm
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addVote(Request $request, $npm)
    {
        $pemilih = Pemilih::where('npm', $npm)->first();
        $paslon = Paslon::find($request->input('paslon_id')); // Ambil ID paslon dari request
        $jenisPemilihan = Session::get('jenis_pemilihan');
        $user = Session::get('prodi');

        // Special handling for himabig, hicomlog, and himamera
        if (in_array($jenisPemilihan, ['himabig', 'hicomlog', 'himamera'])) {
            if ($request->input('jenis_vote') == 'presma') {
                if ($pemilih->pml_presma == 0) {
                    $pemilih->pml_presma += 1;
                    $pemilih->save();
                    
                    $pemilih->update(['total_vote' => $pemilih->pml_presma]);
                    $paslon->increment('total_vote');
                    
                    // Logout immediately after voting
                    Auth::logout();
                    return redirect()->route('login')->with('success', 'Terima kasih, Anda telah memberikan vote.');
                }
            }
            return redirect()->back()->with('error', 'Anda hanya dapat memilih Presma.');
        }

        // Regular voting logic for other programs
        if ($request->input('jenis_vote') == 'presma') {
            if ($pemilih->pml_presma == 0) {
                $pemilih->pml_presma += 1; // Tambah vote Presma
                $pemilih->save();

                $pemilih->update(['total_vote' => $pemilih->pml_presma + $pemilih->pml_hima]); // Update total_vote
                $paslon->increment('total_vote');
            } else {
                $pemilih->pml_presma -= 1; // Kurangi vote Presma
                $pemilih->save();

                $pemilih->update(['total_vote' => $pemilih->pml_presma + $pemilih->pml_hima]); // Update total_vote
                $paslon->decrement('total_vote');
            }
        } elseif ($request->input('jenis_vote') == $jenisPemilihan) {
            if ($pemilih->pml_hima == 0) {
                $pemilih->pml_hima += 1; // Tambah vote Hima
                $pemilih->save();

                $pemilih->update(['total_vote' => $pemilih->pml_presma + $pemilih->pml_hima]); // Update total_vote
                $paslon->increment('total_vote');
            } else {
                $pemilih->pml_hima -= 1; // Kurangi vote Hima
                $pemilih->save();

                $pemilih->update(['total_vote' => $pemilih->pml_presma + $pemilih->pml_hima]); // Update total_vote
                $paslon->decrement('total_vote');
            }
        } else {
            return redirect()->back()->with('error', 'Jenis vote tidak valid.');
        }

        // Logout jika total_vote >= 2
        if ($pemilih->total_vote >= 2) {
            Auth::logout();
            return redirect()->route('login')->with('success', 'Terima kasih, Anda telah memberikan vote.');
        }

        return redirect()->route('menuvote', ['prodi' => $user])
            ->with('success', 'Vote berhasil diproses.');
    }

}
