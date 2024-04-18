<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function dashboard(){
        return view ('pages.dashboard');
    }

    public function user(){
        $data = User::get();
        return view ('pages.user.main',compact('data'));
    }

    public function createUser(){
        return view('pages.user.create');
    }

    public function store(Request $request){
        //melakukan validasi terhadap data yang di inputkan 
        $validator = Validator::make($request->all(),[
            'nama'      => 'required',
            'email'     => 'required|email',
            'password'  => 'required',
            'photo'     => 'required|mimes:png,jpg,jpeg|max:2048'
        ]);

        //jika validasi gagal maka akan dikembalikan ke halaman sebelumnya dengan tambahan error
        if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $photo      = $request->file('photo');
        $filename   = date('y-m-d').$photo->getClientOriginalName();
        $path       = 'photo-profile/'.$filename;

        Storage::disk('public')->put($path,file_get_contents($photo));
        
        //mengirimkan data ke database
        $data['name']       = $request->nama;
        $data['email']      = $request->email;
        $data['password']   = Hash::make($request->password);
        $data['image']      = $filename;

        //mengirim perintah create ke database
        User::create($data);

        return redirect()->route('admin.user');
    }

    public function edit(Request $request,$id){
        $data = User::find($id);

        return view ('pages.user.edit',compact('data'));
    }

    public function update(Request $request,$id){
        //melakukan validasi terhadap data yang di inputkan 
        $validator = Validator::make($request->all(),[                    
        'nama'      => 'required',
        'email'     => 'required|email',
        'password'  => 'nullable',
        ]);
        
        //jika validasi gagal maka akan dikembalikan ke halaman sebelumnya dengan tambahan error
        if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);
        
        //mengirimkan data ke database
        $data['name']       = $request->nama;
        $data['email']      = $request->email;
        if($request->password){
            $data['password']   = Hash::make($request->password);
        }

        //mengirim perintah create ke database
        User::whereId($id)->update($data);

        return redirect()->route('admin.user');
    }

    public function delete(Request $request,$id){
        $data = User::find($id);

        if($data){
            $data->delete();
        }

        return redirect()->route('admin.user');
    }

    public function display(){
        return view('pages.display');
    }

    public function form(){
        return view('pages.form');
    }
}
