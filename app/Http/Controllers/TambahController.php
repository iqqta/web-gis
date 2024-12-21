<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sawah;
use App\Models\Jalan;
use App\Models\Wisata;

class TambahController extends Controller
{
    public function sawah()
    {
        return view('addsawah');
    }

    public function jalan()
    {
        return view('addjalan');
    }

    public function wisata()
    {
        return view('addwisata');
    }

    public function storeSawah(Request $request)
    {
        
        // Validasi untuk tipe 'sawah'
        $rules = [
            'owner'         => 'required|string|max:255',
            'area'          => 'required|numeric',
            'planting_date' => 'required|date',
            'commodity'     => 'required|string|max:255',
            'geometry'      => 'required|string|max:255',
        ];

        // Validasi request
        $request->validate($rules);

        // Simpan data untuk tipe 'sawah'
        Sawah::create($request->all());

        // Redirect setelah penyimpanan
        return redirect()->route('sawah');
    }

    public function storeJalan(Request $request)
    {
        // Validasi untuk tipe 'jalan'
        $rules = [
            'road_name' => 'required|string|max:255',
            'condition' => 'required|string|max:255',
            'geometry'  => 'required|string|max:255',
        ];

        // Validasi request
        $request->validate($rules);

        // Simpan data untuk tipe 'jalan'
        Jalan::create($request->all());

        // Redirect setelah penyimpanan
        return redirect()->route('jalan');
    }

    public function storeWisata(Request $request)
    {
        // Validasi untuk tipe 'wisata'
        $rules = [
            'name'        => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'geometry'    => 'required|string|max:255',
        ];

        // Validasi request
        $request->validate($rules);

        // Simpan data untuk tipe 'wisata'
        Wisata::create($request->all());

        // Redirect setelah penyimpanan
        return redirect()->route('wisata');
    }
}
