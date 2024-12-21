<?php

namespace App\Http\Controllers;
use App\Models\Wisata;

use Illuminate\Http\Request;

class WisataController extends Controller
{
    public function index()
    {
        $wisatadata = Wisata::all()->toArray();
        return view('wisata', compact('wisatadata'));
    }
}
