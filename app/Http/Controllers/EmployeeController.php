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

        // $data = $loket; // Simpan data loket dalam variabel $data

        return view('pages.employee.dashboard', compact('data','jumlahAntrian')); // Kembalikan view dengan data loket
    }
}
