<?php

namespace App\Http\Controllers;

use App\Models\antrian;
use App\Models\KategoriPelayanan;
use Illuminate\Http\Request;

class DisplayController extends Controller
{
    public function display(){
        $antrian = antrian::where('status_antrian', 'menunggu')
        ->groupBy('id_kategori_layanan')
        ->selectRaw('id_kategori_layanan, MIN(nomor_urut) AS nomor_urut_terendah')
        ->get();

        // Kembalikan view display antrian dengan data antrian teratas per kategori
        return view('pages.display', compact('antrian'));
    }

    public function form(){
        $kategoriLayanan = KategoriPelayanan::all();
        return response()->json($kategoriLayanan);
    }
}
