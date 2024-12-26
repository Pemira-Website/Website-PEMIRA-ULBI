<?php

namespace App\Http\Controllers;

use App\Models\Accounts;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class VoteController extends Controller
{
    /**
     * Tambahkan vote pada akun tertentu.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addVote($npm)
    {
        // Validasi input
        $userNPM = Session::get('npm');

        // Update total_vote di tabel account
        DB::table('accounts')
            ->where('npm', $userNPM)
            ->increment('total_vote');

        // Redirect kembali dengan pesan sukses
        return back()->with('success', 'Vote berhasil ditambahkan.');
    }
}
