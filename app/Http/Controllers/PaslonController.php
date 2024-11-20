<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaslonController extends Controller
{
    public function paslon()
    {
        return view('vote.paslon');
    }

    public function himatif()
    {
        return view('vote.paslon_himatif');
    }

    public function himagis()
    {
        return view('vote.paslon_himagis');
    }

    public function himalogbis()
    {
        return view('vote.paslon_himalogbis');
    }

    public function hma()
    {
        return view('vote.paslon_hma');
    }

    public function himaporta()
    {
        return view('vote.paslon_himaporta');
    }

    public function himanbis()
    {
        return view('vote.paslon_himanbis');
    }

    public function himasta()
    {
        return view('vote.paslon_himasta');
    }

    public function himabig()
    {
        return view('vote.paslon_himabig');
    }

    public function hicomlog()
    {
        return view('vote.paslon_hicomlog');
    }

    public function himamera()
    {
        return view('vote.paslon_himamera');
    }
}
