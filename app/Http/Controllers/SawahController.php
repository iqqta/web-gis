<?php

namespace App\Http\Controllers;
use App\Models\Sawah;

use Illuminate\Http\Request;

class SawahController extends Controller
{
    public function index()
    {
        $sawahdata = Sawah::all()->toArray();
        return view('sawah', compact('sawahdata'));
    }
}
