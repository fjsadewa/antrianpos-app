<?php

namespace App\Http\Controllers;

use App\Models\antrian;
use App\Models\antrianHistory;
use App\Models\Loket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;

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
        $idLoket = $loket->id;
        
        $antrian = antrian::where('id_kategori_layanan', $kategoriLayananId)
        ->whereDate('tanggal', now())
        ->where('status_antrian', 'menunggu') 
        ->get();
        
        // $antrianSekarang = antrian::where('id_kategori_layanan', $kategoriLayananId)
        // ->whereDate('tanggal', now())
        // ->whereHas('loketPanggil', function ($query) use ($nmrLoket) {
        //     $query->where('nomor_loket', $nmrLoket); })
        // ->whereIn('status_antrian', ['dipanggil', 'dilayani']) 
        // ->get(); 

        $list = antrian::where('id_loket_layani',$idLoket)
        ->where('id_kategori_layanan', $kategoriLayananId)
        ->whereDate('tanggal', now())
        ->where('status_antrian', 'selesai') 
        ->get(); 
        
        // dd($list);
        $jumlahAntrian = $antrian->count();
        $jumlahPelayanan = $list->count();

        $data = ['loket' => $loket];

        return view('pages.employee.dashboard', compact('data','jumlahAntrian','jumlahPelayanan')); 
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
        ->whereDate('tanggal', now())
        ->whereIn('status_antrian', ['dipanggil', 'dilayani'])
        ->whereHas('loketPanggil', function ($query) use ($nmrLoket) {
            $query->where('nomor_loket', $nmrLoket); })
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
        ->whereDate('tanggal', now())
        ->where('status_antrian', 'menunggu')
        ->first();
    
        if ($antrianTerkini) {
            $kodeAntrian    = $antrianTerkini->kategoriLayanan->kode_pelayanan;
            $nomorAntrian   = $antrianTerkini->nomor_urut;
            $nomorLoket     = $loket->nomor_loket;
            $namaPetugas    = $loket->employee->name;
            $namaPelayanan  = $antrianTerkini->kategoriLayanan->nama_pelayanan;
            $photo = $loket->employee->image;
    
            $antrianTerkini['kodeAntrian']= $kodeAntrian;
            $antrianTerkini['nomorAntrian']= $nomorAntrian;
            $antrianTerkini['nomorLoket']= $nomorLoket;
            $antrianTerkini['namaPetugas'] = $namaPetugas;
            $antrianTerkini['namaPelayanan'] = $namaPelayanan;
            $antrianTerkini['photo'] = $photo;

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
            ->whereDate('tanggal', now())
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
            $antrianTerdepan->nama_petugas = $loket->employee->name;
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
            ->whereDate('tanggal', now())
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
            ->whereDate('tanggal', now())
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
            ->whereDate('tanggal', now())
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
            $antrianTerdepan->id_loket_layani = $loket->id;
            $antrianTerdepan->waktu_selesai_layani = now();
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

    public function antrianSekarangData(Request $request){
        // die();
        if($request->ajax()){
            $userId = Auth::user()->id; 
            $loket = Loket::where('user_id', $userId)->first(); 
        
            $kategoriLayananId = $loket->kategori_pelayanan_id;
            $nmrLoket = $loket->nomor_loket;
            
            $data = antrian::where('id_kategori_layanan', $kategoriLayananId)
            ->whereDate('tanggal', now())
            ->whereHas('loketPanggil', function ($query) use ($nmrLoket) {
                $query->where('nomor_loket', $nmrLoket); })
            ->whereIn('status_antrian', ['dipanggil', 'dilayani']) 
            ->with(['kategoriLayanan'=>function($query){
                $query->select('id','kode_pelayanan','nama_pelayanan');
            }])
            ->get(); 
            
            // return response()->json($data);
            return Datatables::of($data)
                    ->make(true);
        }
    }

    public function antrianData(Request $request){
        // die();
        if($request->ajax()){
            $userId = Auth::user()->id; 
            $loket = Loket::where('user_id', $userId)->first(); 
        
            $kategoriLayananId = $loket->kategori_pelayanan_id;
            
            $data = antrian::where('id_kategori_layanan', $kategoriLayananId)
            ->whereDate('tanggal', now())
            ->where('status_antrian', 'menunggu')  
            ->with(['kategoriLayanan'=>function($query){
                $query->select('id','kode_pelayanan','nama_pelayanan');
            }])
            ->get(); 
            
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->make(true);
        }
    }

    public function history($id){
        $userId = Auth::user()->id; 
        $loket = Loket::where('user_id', $userId)->first();

        if (!$loket) {
            return redirect()->back()->withError('Loket tidak ditemukan');
        }
        $kategoriLayananId = $loket->kategori_pelayanan_id;
        $loketId =  $loket->id;

    
        $data = ['loket' => $loket, 'kategori' => $kategoriLayananId];
        return view ('pages.employee.history',compact('data'));
    }

    public function userHistory(Request $request){
        $userId = Auth::user()->id;
        $loket = Loket::where('user_id', $userId)->first();

        if (!$loket) {
            return response()->json([
                'message' => 'Loket tidak ditemukan',
            ], 404);
        }

        $loketId = $loket->id;

        $antrianHistory = AntrianHistory::where('id_loket_panggil', $loketId)
            ->selectRaw('tanggal, 
                        SUM(CASE WHEN status_antrian = "DIPANGGIL" THEN 1 ELSE 0 END) AS jumlah_dipanggil,
                        SUM(CASE WHEN status_antrian = "SELESAI" THEN 1 ELSE 0 END) AS jumlah_selesai,
                        SUM(CASE WHEN status_antrian = "LEWATI" THEN 1 ELSE 0 END) AS jumlah_dilewati')
            ->groupBy('tanggal')
            ->get();

        return Datatables::of($antrianHistory)
            ->make(true);
    }

    public function getJumlahAntrianBelumTerpanggil($loketId) {
        $loket = Loket::find($loketId);
        if (!$loket) {
            return response()->json(['error' => 'Loket tidak ditemukan'], 404);
        }

        $kategoriLayananId = $loket->kategori_pelayanan_id;

        $jumlahAntrianBelumTerpanggil = Antrian::where('id_kategori_layanan', $kategoriLayananId)
            ->whereDate('tanggal', now())
            ->where('status_antrian', 'menunggu')
            ->count();

        return response()->json(['jumlahAntrianBelumTerpanggil' => $jumlahAntrianBelumTerpanggil]);
    }

    public function getJumlahPelayananHariIni($loketId) {
        $loket = Loket::find($loketId);
        if (!$loket) {
            return response()->json(['error' => 'Loket tidak ditemukan'], 404);
        }

        $kategoriLayananId = $loket->kategori_pelayanan_id;

        $jumlahPelayananHariIni = Antrian::where('id_loket_layani', $loketId)
            ->where('id_kategori_layanan', $kategoriLayananId)
            ->whereDate('tanggal', now())
            ->where('status_antrian', 'selesai')
            ->count();

        return response()->json(['jumlahPelayananHariIni' => $jumlahPelayananHariIni]);
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
            
