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
     * @param  string  $npm
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addVote(Request $request, $npm)
    {
        $pemilih = Pemilih::where('npm', $npm)->first();
        
        if (!$pemilih) {
            return redirect()->back()->with('error', 'Pemilih tidak ditemukan.');
        }

        $paslon = Paslon::find($request->input('paslon_id'));
        
        if (!$paslon) {
            return redirect()->back()->with('error', 'Paslon tidak ditemukan.');
        }

        $jenisPemilihanRaw = Session::get('jenis_pemilihan');
        $user = Session::get('prodi');
        $jenisVote = $request->input('jenis_vote');

        // Parse jenis_pemilihan (format: "presma,himatif" atau single value)
        $allowedVotes = array_map('trim', explode(',', $jenisPemilihanRaw));
        
        // Check if this vote type is allowed for this pemilih
        $himaType = null;
        foreach ($allowedVotes as $vote) {
            if ($vote !== 'presma') {
                $himaType = $vote;
                break;
            }
        }

        // Special handling for himabig, hicomlog, and himamera (only presma)
        if (in_array($himaType, ['himabig', 'hicomlog', 'himamera'])) {
            if ($jenisVote == 'presma') {
                if ($pemilih->pml_presma == 0) {
                    $pemilih->pml_presma = 1;
                    $pemilih->total_vote = 1;
                    $pemilih->save();
                    
                    $paslon->increment('total_vote');
                    
                    Session::flush();
                    return redirect()->route('login')->with('success', 'Terima kasih, Anda telah memberikan vote.');
                }
                return redirect()->back()->with('error', 'Anda sudah memberikan vote untuk Presma.');
            }
            return redirect()->back()->with('error', 'Anda hanya dapat memilih Presma.');
        }

        // Regular voting logic
        if ($jenisVote == 'presma') {
            if ($pemilih->pml_presma == 0) {
                $pemilih->pml_presma = 1;
                $pemilih->total_vote = $pemilih->pml_presma + $pemilih->pml_hima;
                $pemilih->save();
                $paslon->increment('total_vote');
            } else {
                return redirect()->back()->with('error', 'Anda sudah memberikan vote untuk Presma.');
            }
        } elseif ($jenisVote == $himaType) {
            if ($pemilih->pml_hima == 0) {
                $pemilih->pml_hima = 1;
                $pemilih->total_vote = $pemilih->pml_presma + $pemilih->pml_hima;
                $pemilih->save();
                $paslon->increment('total_vote');
            } else {
                return redirect()->back()->with('error', 'Anda sudah memberikan vote untuk Himpunan.');
            }
        } else {
            return redirect()->back()->with('error', 'Jenis vote tidak valid.');
        }

        // Logout jika total_vote >= 2
        if ($pemilih->total_vote >= 2) {
            Session::flush();
            return redirect()->route('login')->with('success', 'Terima kasih, Anda telah memberikan vote.');
        }

        return redirect()->route('menuvote', ['prodi' => $user])
            ->with('success', 'Vote berhasil diproses.');
    }
}
