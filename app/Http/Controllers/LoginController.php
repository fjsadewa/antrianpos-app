<?php

namespace App\Http\Controllers;

use App\Models\antrian;
use App\Models\antrianHistory;
use App\Models\Loket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class LoginController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('guest')->except('logout');
    // }

    public function login(){
        return view('auth.login');
    }

    public function login_process(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        
        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($data)){
            $user = auth()->user();
            
            // $loket = Loket::where('user_id', $user->id)->first();

            // if ($loket) {
            //     $activeUsers = Loket::where('nomor_loket', $loket->nomor_loket)
            //                         ->where('user_id', '!=', $user->id)
            //                         ->exists();

            //     if ($activeUsers) {
            //         Auth::logout();
            //         return redirect()->route('login')->with('failed','Loket ini sudah digunakan oleh pengguna lain.');
            //     }
            // }

            $role = $user->roles->first();
            //$cacheKey = 'login_function_' . $user->id . '_' . date('Y-m-d') . '_' . $user->created_at->format('YmdHi');
            $cacheKey = 'login_function_' . date('Y-m-d');
            if (!Cache::has($cacheKey)) {
                //$this->moveData($user->created_at->format('Y-m-d'));
                $this->moveData(date('Y-m-d'));
                Cache::put($cacheKey, true, now()->addDay());
            }

            if($role-> name === 'admin'){
                return redirect()->route('admin.dashboard');
            } elseif ($role-> name === 'employee') {;
                return redirect()->route('employee.dashboardEmployee',['id'=>$user->id]);
            } else{
                return redirect()->route('login')->with('failed','Anda tidak memiliki Akses');
            }
        }else{
            return redirect()->route('login')->with('failed','Email atau password salah');
        };
    }

    private function moveData($userLoginDate){
        $antrians = Antrian::all();

        foreach ($antrians as $antrian) {
            $antrianHistory = new AntrianHistory;
            $antrianHistory->id_kategori_layanan = $antrian->id_kategori_layanan;
            $antrianHistory->nama_pelayanan = $antrian->nama_pelayanan;
            $antrianHistory->nomor_urut = $antrian->nomor_urut;
            $antrianHistory->nama_petugas = $antrian->nama_petugas;
            $antrianHistory->status_antrian = $antrian->status_antrian;
            $antrianHistory->id_loket_panggil = $antrian->id_loket_panggil;
            $antrianHistory->waktu_panggil = $antrian->waktu_panggil;
            $antrianHistory->id_loket_layani = $antrian->id_loket_layani;
            $antrianHistory->waktu_selesai_layani = $antrian->waktu_selesai_layani;
            $antrianHistory->tanggal = $userLoginDate;
            $antrianHistory->save();

            $antrian->delete();
        }
    }

    public function logout(Request $request){
        Auth::logout();
        return redirect()->route('login')->with('success','Terima Kasih untuk hari ini!');
    }

}
