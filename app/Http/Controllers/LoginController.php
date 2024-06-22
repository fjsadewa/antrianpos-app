<?php

namespace App\Http\Controllers;

use App\Models\antrian;
use App\Models\antrianHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class LoginController extends Controller
{

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
            $role = $user->roles->first();
            $userId = $user->id;
            $cacheKey = 'login_function_' . $user->id . '_' . date('Y-m-d') . '_' . $user->created_at->format('YmdHi');

            if (!Cache::has($cacheKey)) {
                $this->moveData($user->created_at->format('Y-m-d'));
                Cache::put($cacheKey, true, now()->addDay());
            }

            if($role-> name === 'admin'){
                return redirect()->route('admin.dashboard');
            } elseif ($role-> name === 'employee') {;
                return redirect()->route('employee.dashboardEmployee',['id'=>$userId]);
            } else{
                return redirect()->route('login')->with('failed','Anda tidak memiliki Akses');
            }
        }else{
            return redirect()->route('login')->with('failed','Email atau password salah');
        };
    }

    private function moveData($userLoginDate)
    {
        $antrians = Antrian::all();

        foreach ($antrians as $antrian) {
            $antrianHistory = new AntrianHistory;
            $antrianHistory->id_kategori_layanan = $antrian->id_kategori_layanan;
            $antrianHistory->nomor_urut = $antrian->nomor_urut;
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
