<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Accounts;

use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function presma() {
        $Presma = Accounts::all();
        $hasilVote = array();
        foreach($Presma as $vote) {
            $hasilVote[] = $vote->total_vote;
        }
        return view('chart.hasilvoting', compact('Presma', 'hasilVote'));
    }
}
