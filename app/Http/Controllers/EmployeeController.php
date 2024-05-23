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
        $userId = Auth::user()->id; // Dapatkan user id saat login
        $loket = Loket::where('user_id', $userId)->first(); // Cari loket berdasarkan user id
        
        if (!$loket) {
            // Handle error jika loket tidak ditemukan
            return redirect()->back()->withError('Loket tidak ditemukan');
        }

        $kategoriLayananId = $loket->kategori_pelayanan_id;
        
        $antrian = antrian::where('id_kategori_layanan', $kategoriLayananId)
        ->where('status_antrian', 'menunggu') // Ubah status antrian yang ingin ditampilkan
        ->get(); // Ambil data antrian

        $jumlahAntrian = $antrian->count();

        $data = ['loket' => $loket, 'antrian' => $antrian]; // Simpan data loket dan antrian dalam variabel $data

        return view('pages.employee.dashboard', compact('data','jumlahAntrian')); // Kembalikan view dengan data loket
    }

    public function getAntrian($id){
        $loket = Loket::where('user_id',$id)->first();
        if ($loket) {
            $kategoriLayananId = $loket->kategori_pelayanan_id;
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Loket tidak ditemukan'
            ]);
        }
    
        $antrianTerkini = Antrian::where('id_kategori_layanan', $kategoriLayananId)
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
                'message' => 'Antrian berhasil dipanggil',
                'data' => $antrianTerkini,
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Antrian terkini tidak ditemukan'
            ]);
        }
    }

    public function updateAntrian($id){
        $loket = Loket::where('user_id',$id)->first();
        if($loket){
            $kategoriLayananId = $loket->kategori_pelayanan_id;
            
            $antrianTerdepan = Antrian::where('id_kategori_layanan', $kategoriLayananId)
            ->where('status_antrian', 'menunggu')
            ->first();
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Loket tidak ditemukan'
            ]);
        }
        // dd($antrianTerdepan);

        if ($antrianTerdepan !=null) {
            $antrianTerdepan->status_antrian = 'dipanggil';
            $antrianTerdepan->id_loket_panggil = $loket->id;
            $antrianTerdepan->waktu_panggil = now();
            $antrianTerdepan->save();

            // $kodeAntrian = $antrianTerdepan->kategoriLayanan->kode_pelayanan;
            // $nomorAntrian = $antrianTerdepan->nomor_urut;
            // $nomorLoket = $loket->nomor_loket;

            return response()->json([
                'status' => 'success',
                'message' => 'Antrian berhasil diupdate',
                // 'data' => [
                //     'kodeAntrian' => $kodeAntrian,
                //     'nomorAntrian' => $nomorAntrian,
                //     'nomorLoket'=> $nomorLoket,
                // ],
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
            
