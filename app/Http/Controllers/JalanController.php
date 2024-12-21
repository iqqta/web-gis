<?php

namespace App\Http\Controllers;
use App\Models\Jalan;

use Illuminate\Http\Request;

class JalanController extends Controller
{
    public function index()
    {
        $jalandata = Jalan::all()->toArray();
        return view('jalan', compact('jalandata'));
    }
}
