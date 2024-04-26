<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class HomeController extends Controller
{

    public function __construct(){
    $this->middleware(['role:admin','permission:view_admin']);
    }

    public function dashboard(){
        return view ('pages.user.dashboard');
    }

    public function user(){
        $data = User::with('roles')->get();
        return view ('pages.user.main',compact('data'));
    }

    public function createUser(){
        $roles = Role::all();
        return view('pages.user.create',compact('roles'));
    }

    public function store(Request $request){
        //melakukan validasi terhadap data yang di inputkan 
        $validator = Validator::make($request->all(),[
            'nama'      => 'required',
            'email'     => 'required|email',
            'password'  => 'required',
            'photo'     => 'required|mimes:png,jpg,jpeg|max:2048',
            'role'      => 'required'
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
        $user = User::create($data);

        if ($request->role == 1) {
            $user->assignRole(['admin']);
        } else {
            $user->assignRole(['employee']);
        }

        return redirect()->route('admin.user');
    }

    public function edit(Request $request,$id){
        $data = User::find($id);
        $roles = Role::all();

        return view ('pages.user.edit',compact('data','roles'));
    }

    public function update(Request $request,$id){
        //melakukan validasi terhadap data yang di inputkan 
        $validator = Validator::make($request->all(),[                    
        'nama'      => 'required',
        'email'     => 'required|email',
        'password'  => 'nullable',
        'photo'     => 'required|mimes:png,jpg,jpeg|max:2048'
        ]);
        
        //jika validasi gagal maka akan dikembalikan ke halaman sebelumnya dengan tambahan error
        if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);
        
        $find = User::find($id);
        //mengirimkan data ke database
        $data['name']       = $request->nama;
        $data['email']      = $request->email;
        if($request->password){
            $data['password']   = Hash::make($request->password);
        }

        $photo      = $request->file('photo');
        if ($photo) {
            $filename   = date('y-m-d').$photo->getClientOriginalName();
            $path       = 'photo-profile/'.$filename;
            
            if ($find->image) {
                Storage::disk('public')->delete('photo-profile/'.$find->image);
            }
            Storage::disk('public')->put($path,file_get_contents($photo));

            $data ['image']     = $filename;
        }

        
        $data = User::find($id);
        
        if ($request->role == 1) {
            $data->assignRole(['admin']);
        } else {
            $data->assignRole(['employee']);
        }
        
        //mengirim perintah update ke database
        if($data){
            if($data->update()){
                return redirect()->route('admin.user')->with('success','Berhasil Melakukan Update! ');
            } else {
                return redirect()->route('admin.user')->with('failed','Update gagal Gagal');
            }
        }else {
        return redirect()->route('admin.user')->with('warning', 'User dengan ID tersebut tidak ditemukan');
        }

    }

    public function delete(Request $request,$id){
        $data = User::find($id);

        if($data){
            if($data->delete()){
                return redirect()->route('admin.user')->with('success','Pengguna berhasil dihapus');
            } else {
                return redirect()->route('admin.user')->with('failed','Penghapusan Gagal');
            }
        }else {
            return redirect()->route('admin.user')->with('warning', 'User dengan ID tersebut tidak ditemukan');
        }
    }


    public function displaySetting(){
        return view('pages.setting.displayset');
    }
}
