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

        // Calculate special states before returning immediately
        $isPresmaVoted = $pemilih->pml_presma == 1;
        $isHimaVoted = $pemilih->pml_hima == 1;
        
        $willBeFinished = false;
        $errorMessage = null;

        if (in_array($himaType, ['himabig', 'hicomlog', 'himamera'])) {
            if ($jenisVote != 'presma') {
                $errorMessage = 'Anda hanya dapat memilih Presma.';
            } else if ($isPresmaVoted) {
                $errorMessage = 'Anda sudah memberikan vote untuk Presma.';
            } else {
                $willBeFinished = true;
            }
        } else {
            if ($jenisVote == 'presma' && $isPresmaVoted) {
                $errorMessage = 'Anda sudah memberikan vote untuk Presma.';
            } elseif ($jenisVote == $himaType && $isHimaVoted) {
                $errorMessage = 'Anda sudah memberikan vote untuk Himpunan.';
            } elseif (!in_array($jenisVote, ['presma', $himaType])) {
                $errorMessage = 'Jenis vote tidak valid.';
            } else {
                $willBeFinished = ($pemilih->total_vote + 1) >= 2;
            }
        }

        if ($errorMessage) {
            return redirect()->back()->with('error', $errorMessage);
        }

        // Dispatch background job to Redis Queue (Message Broker)
        \App\Jobs\ProcessVote::dispatch($pemilih->id, $paslon->id, $jenisVote, $himaType);

        // Immediate response for high throughput
        if ($willBeFinished) {
            Session::flush();
            return redirect()->route('login')->with('success', 'Vote Anda sedang diproses. Terima kasih! (Harap tunggu 1-2 menit hingga chart diperbarui)');
        }

        // Increment total vote locally for redirection purpose (frontend logic bypass)
        $pemilih->total_vote += 1;

        if ($pemilih->total_vote >= 2) {
             Session::flush();
             return redirect()->route('login')->with('success', 'Vote Anda sedang diproses. Terima kasih! (Harap tunggu 1-2 menit hingga chart diperbarui)');
        }

        return redirect()->route('menuvote', ['prodi' => $user])
            ->with('success', 'Berhasil! Vote diproses ke dalam antrean (Queue).');
    }
}
