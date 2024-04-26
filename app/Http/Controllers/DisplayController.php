<?php

namespace App\Http\Controllers;

use App\Models\antrian;
use App\Models\KategoriPelayanan;
use Illuminate\Http\Request;

class DisplayController extends Controller
{
    public function display(){
        $kategoriLayanan = KategoriPelayanan::all();

        // Inisialisasi array untuk menyimpan antrian teratas per kategori
        $antrianTeratas = [];

        // Looping melalui setiap kategori layanan
        foreach ($kategoriLayanan as $kategori) {
        // Dapatkan antrian teratas untuk kategori tersebut
        $antrianTeratasKategori = antrian::where('id_kategori_layanan', $kategori->id)
                                        ->orderBy('nomor_urut', 'asc')
                                        ->limit(1)
                                        ->first();

        // Tambahkan antrian teratas ke array
        $antrianTeratas[$kategori->kode_kategori] = $antrianTeratasKategori;
        }

        // Kembalikan view display antrian dengan data antrian teratas per kategori
        return view('pages.display', ['antrianTeratas' => $antrianTeratas]);
    }

    public function form(){
        $kategoriLayanan = KategoriPelayanan::get();
        return view('pages.form',compact('kategoriLayanan'));
    }
}
