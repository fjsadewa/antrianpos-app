<?php

namespace App\Http\Controllers;

use App\Models\antrian;
use App\Models\KategoriPelayanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AntrianController extends Controller
{
    public function createAntrian($id){
        $kategoriLayanan = KategoriPelayanan::find($id);

        if (!$kategoriLayanan) {
            return Response::json(['success' => false, 'message' => 'Kategori layanan tidak ditemukan'], 404);
        }

        // Hitung nomor urut baru
        $nomorUrutBaru = antrian::where('id_kategori_layanan', $kategoriLayanan->id)->max('nomor_urut') + 1;

        // Buat antrian baru
        $dataForm = [
            'id_kategori_layanan' => $kategoriLayanan->id,
            'nomor_urut' => $nomorUrutBaru,
            'status_antrian' => 'menunggu',
        ];

        antrian::create($dataForm);
    
        // return redirect()->route('form');
        return Response::json(['success' => true, 'dataForm' => $dataForm, 'message' => 'Form antrian berhasil dibuat!'], 200);
    }

    public function getAntrian(){
        
    }
}
