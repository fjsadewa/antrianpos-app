<?php

namespace App\Http\Controllers;

use App\Models\addText;
use App\Models\antrian;
use App\Models\KategoriPelayanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;

class AntrianController extends Controller
{
    public function createAntrian($id){
        $kategoriLayanan = KategoriPelayanan::find($id);
        $tanggalHariIni = now()->format('Y-m-d');

        if (!$kategoriLayanan) {
            return Response::json(['success' => false, 'message' => 'Kategori layanan tidak ditemukan'], 404);
        }

        // Hitung nomor urut baru
        $nomorUrutBaru = antrian::where('id_kategori_layanan', $kategoriLayanan->id)
            ->whereDate('tanggal', now())
            ->max('nomor_urut') + 1;

        // Buat antrian baru
        $dataForm = [
            'id_kategori_layanan' => $kategoriLayanan->id,
            'nama_pelayanan' => $kategoriLayanan->nama_pelayanan,
            'nomor_urut' => $nomorUrutBaru,
            'tanggal' => $tanggalHariIni,
            'status_antrian' => 'menunggu',
        ];

        antrian::create($dataForm);
        $this->sendSocketNotification();
        return Response::json(['success' => true, 'dataForm' => $dataForm, 'message' => 'Form antrian berhasil dibuat!'], 200);
    }

    private function sendSocketNotification(){
        Http::post('http://localhost:3000/notify');
    }

    public function getAntrian(){
        $latestQueue = Antrian::latest()->select('id_kategori_layanan', 'nomor_urut')
            ->whereDate('tanggal', now())
            ->first();
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
