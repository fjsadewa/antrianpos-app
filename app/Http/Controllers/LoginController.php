<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
            return redirect()->route('admin.dashboard');
        }else{
            return redirect()->route('login')->with('failed','Email atau password salah');
        };
    }

    public function logout(Request $request){
        Auth::logout();
        return redirect()->route('login')->with('success','Terima Kasih untuk hari ini!');
    }

}
