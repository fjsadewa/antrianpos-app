<?php

namespace App\Http\Controllers;

use App\Models\addText;
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
        return Response::json(['success' => true, 'dataForm' => $dataForm, 'message' => 'Form antrian berhasil dibuat!'], 200);
    }

    public function getAntrian(){
        $latestQueue = Antrian::latest()->select('id_kategori_layanan', 'nomor_urut')->first();
        $textData = addText::first();

        if ($latestQueue) {
            $serviceInfo = KategoriPelayanan::find($latestQueue->id_kategori_layanan);
            $kode = $serviceInfo->kode_pelayanan;
            $nama = $serviceInfo->nama_pelayanan;
            $day = now()->locale('id')->format('d');
            $month = \Carbon\Carbon::now()->locale('id')->monthName;
            $year = now()->locale('id')->format('Y');
            $time = now()->locale('id')->format('H:i');
            $text = $textData->text;
            $curday = "$day $month $year $time";
            $data = [
                "nomor_urut" => $latestQueue->nomor_urut,
                "kode_pelayanan" => $kode,
                "nama_pelayanan" => $nama,
                "timestamp" => $curday,
                "addText" => $text,
            ];
            return response()->json($data);
        } else {
            return response()->json([], 404);
        }
    }
}
