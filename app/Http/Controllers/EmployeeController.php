<?php

namespace App\Http\Controllers;

use App\Models\antrian;
use App\Models\Loket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function __construct(){
        $this->middleware(['role_or_permission:employee|view_admin']);
        }

    public function dashboardEmployee(Request $request){
        $userId = Auth::user()->id; 
        $loket = Loket::where('user_id', $userId)->first(); 
        
        if (!$loket) {
            return redirect()->back()->withError('Loket tidak ditemukan');
        }

        $kategoriLayananId = $loket->kategori_pelayanan_id;
        $nmrLoket = $loket->nomor_loket;
        
        $antrian = antrian::where('id_kategori_layanan', $kategoriLayananId)
        ->where('status_antrian', 'menunggu') 
        ->get(); 
        
        $antrianSekarang = antrian::where('id_kategori_layanan', $kategoriLayananId)
        ->whereHas('loketPanggil', function ($query) use ($nmrLoket) {
            $query->where('nomor_loket', $nmrLoket); })
        ->whereIn('status_antrian', ['dipanggil', 'dilayani']) 
        ->get(); 
        // dd($antrianSekarang);
        $jumlahAntrian = $antrian->count();

        $data = ['loket' => $loket, 'antrian' => $antrian, 'antrianSekarang' => $antrianSekarang];

        return view('pages.employee.dashboard', compact('data','jumlahAntrian')); 
    }

    public function getAntrian($id){
        $loket = Loket::where('user_id',$id)->first();
        $nmrLoket = $loket->nomor_loket;
        if ($loket) {
            $kategoriLayananId = $loket->kategori_pelayanan_id;
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Loket tidak ditemukan'
            ]);
        }

        $antrianDipanggil = Antrian::where('id_kategori_layanan', $kategoriLayananId)
        ->whereHas('loketPanggil', function ($query) use ($nmrLoket) {
            $query->where('nomor_loket', $nmrLoket); })
        ->whereIn('status_antrian', ['dipanggil', 'dilayani'])
        ->first();

        if ($antrianDipanggil) {
            $kodeAntrian    = $antrianDipanggil->kategoriLayanan->kode_pelayanan;
            $nomorAntrian   = $antrianDipanggil->nomor_urut;
            $nomorLoket     = $loket->nomor_loket;
            $namaPetugas    = $loket->employee->name;
            $namaPelayanan  = $antrianDipanggil->kategoriLayanan->nama_pelayanan;
            $photo = $loket->employee->image;

            $antrianDipanggil['kodeAntrian'] = $kodeAntrian;
            $antrianDipanggil['nomorAntrian'] = $nomorAntrian;
            $antrianDipanggil['nomorLoket'] = $nomorLoket;
            $antrianDipanggil['namaPetugas'] = $namaPetugas;
            $antrianDipanggil['namaPelayanan'] = $namaPelayanan;
            $antrianDipanggil['photo'] = $photo;

            return response()->json([
                'status' => 'success',
                'message' => 'Antrian sedang dipanggil',
                'data' => $antrianDipanggil
            ]);
        }

        $antrianTerkini = Antrian::where('id_kategori_layanan', $kategoriLayananId)
        // ->whereHas('loketPanggil', function ($query) use ($nmrLoket) {
        //     $query->where('nomor_loket', $nmrLoket); })
        ->where('status_antrian', 'menunggu')
        ->first();
    
        if ($antrianTerkini) {
            $kodeAntrian    = $antrianTerkini->kategoriLayanan->kode_pelayanan;
            $nomorAntrian   = $antrianTerkini->nomor_urut;
            $nomorLoket     = $loket->nomor_loket;
    
            $antrianTerkini['kodeAntrian']= $kodeAntrian;
            $antrianTerkini['nomorAntrian']= $nomorAntrian;
            $antrianTerkini['nomorLoket']= $nomorLoket;

            return response()->json([
                'status' => 'success',
                'message' => 'Antrian sedang menunggu',
                'data' => $antrianTerkini,
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Antrian terkini tidak ditemukan'
            ]);
        }
    }

    public function panggilAntrian($id){
        $loket = Loket::where('user_id',$id)->first();
        if($loket){
            $kategoriLayananId = $loket->kategori_pelayanan_id;
            // $nmrLoket = $loket->nomor_loket;
            
            $antrianTerdepan = Antrian::where('id_kategori_layanan', $kategoriLayananId)
            // ->whereHas('loketPanggil', function ($query) use ($nmrLoket) {
            //     $query->where('nomor_loket', $nmrLoket); })
            ->where('status_antrian', 'menunggu')
            ->first();
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Loket tidak ditemukan'
            ]);
        }

        if ($antrianTerdepan !=null) {
            $antrianTerdepan->status_antrian = 'dipanggil';
            $antrianTerdepan->id_loket_panggil = $loket->id;
            $antrianTerdepan->waktu_panggil = now();
            $antrianTerdepan->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Antrian berhasil diupdate',
            ]);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'Antrian tidak ditemukan',
            ]);
        }
    }

    public function lewatiAntrian($id){
        $loket = Loket::where('user_id',$id)->first();
        if($loket){
            $kategoriLayananId = $loket->kategori_pelayanan_id;
            
            $antrianTerdepan = Antrian::where('id_kategori_layanan', $kategoriLayananId)
            ->where('status_antrian', 'dipanggil')
            ->first();
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Loket tidak ditemukan'
            ]);
        }

        if ($antrianTerdepan !=null) {
            $antrianTerdepan->status_antrian = 'lewati';
            $antrianTerdepan->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Antrian berhasil dilewati',
            ]);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'Antrian tidak ditemukan',
            ]);
        }
    }

    public function mulaiAntrian($id){
        $loket = Loket::where('user_id',$id)->first();
        if($loket){
            $nmrLoket = $loket->nomor_loket;
            $kategoriLayananId = $loket->kategori_pelayanan_id;
            
            $antrianTerdepan = Antrian::where('id_kategori_layanan', $kategoriLayananId)
            ->whereHas('loketPanggil', function ($query) use ($nmrLoket) {
                $query->where('nomor_loket', $nmrLoket); })
            ->where('status_antrian', 'dipanggil')
            ->first();
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Loket tidak ditemukan'
            ]);
        }

        if ($antrianTerdepan !=null) {
            $antrianTerdepan->status_antrian = 'dilayani';
            $antrianTerdepan->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil memulai antrian',
            ]);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'Antrian tidak ditemukan',
            ]);
        }
    }

    public function selesai($id){
        $loket = Loket::where('user_id',$id)->first();
        if($loket){
            $kategoriLayananId = $loket->kategori_pelayanan_id;
            $nmrLoket = $loket->nomor_loket;

            $antrianTerdepan = Antrian::where('id_kategori_layanan', $kategoriLayananId)
            ->whereHas('loketPanggil', function ($query) use ($nmrLoket) {
                $query->where('nomor_loket', $nmrLoket); })
            ->where('status_antrian', 'dilayani')
            ->first();
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Loket tidak ditemukan'
            ]);
        }

        if ($antrianTerdepan !=null) {
            $antrianTerdepan->status_antrian = 'selesai';
            $antrianTerdepan->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil memulai antrian',
            ]);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'Antrian tidak ditemukan',
            ]);
        }
    }
}

// $audio = [];
            // $audio[] = 'bell.mp3'; // Bunyi bell
            // $audio[] = 'kalimat/antrian-nomor-' . $antrianTerdepan->nomor_urut . '.mp3'; // Nomor antrian
            // $audio[] = 'kalimat/silahkan-ke-loket.mp3'; // Kalimat "silahkan ke loket"
            
            // // Gabungkan audio menjadi string URL
            // $audioUrl = route('playAudio', ['audio' => implode(',', $audio)]);

            // // Buat request ke halaman pemutar audio
            // \Http::get($audioUrl);
            
