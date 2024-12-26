<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoteController extends Controller
{
    /**
     * Tambahkan vote pada akun tertentu.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addVote(Request $request)
    {
        // Validasi input
        $request->validate([
            'account_id' => 'required|exists:accounts,id', // Pastikan account_id valid
        ]);

        // Update total_vote di tabel account
        DB::table('accounts')
            ->where('id', $request->account_id)
            ->increment('total_vote');

        // Redirect kembali dengan pesan sukses
        return back()->with('success', 'Vote berhasil ditambahkan.');
    }
}
