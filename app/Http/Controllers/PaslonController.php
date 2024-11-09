<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaslonController extends Controller
{
    public function paslon()
    {
        return view('paslon');
    }
}
