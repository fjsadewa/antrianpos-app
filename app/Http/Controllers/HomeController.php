<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Footer;
use App\Models\Loket;
use App\Models\User;
use App\Models\Video;
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
        'photo'     => 'nullable|mimes:png,jpg,jpeg|max:2048'
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
        
        if ($request->role == 1) {
            $find->syncRoles(['admin']);
        } else {
            $find->syncRoles(['employee']);
        }
        
        //mengirim perintah update ke database
        if($find){
            if($find->update($data)){
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
            if($data->delete($data)){
                return redirect()->route('admin.user')->with('success','Pengguna berhasil dihapus');
            } else {
                return redirect()->route('admin.user')->with('failed','Penghapusan Gagal');
            }
        }else {
            return redirect()->route('admin.user')->with('warning', 'User dengan ID tersebut tidak ditemukan');
        }
    }


    public function displaySetting(){
        $banner = Banner::get();
        $footer = Footer::get();
        return view('pages.setting.displayset',compact('banner','footer'));
    }

    public function createVideo(){
        return view('pages.setting.createVideo');
    }

    public function storeVideo(Request $request){
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'tipe' => 'required|in:youtube,local',
            'link_sumber' => 'required|string',
        ]);
        if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);
        
        $data = $request->validated();
        $judul = $data['judul'];
        $tipe = $data['tipe'];
        $linkSumber = $data['link_sumber'];
        
        // dd($request->validated());
        // Menyimpan video berdasarkan tipe
        if ($tipe === 'youtube') {
            // Simpan link Youtube langsung ke database
            Video::create([
                'judul' => $judul,
                'tipe' => $tipe,
                'link_sumber' => $linkSumber,
            ]);
        } else if ($tipe === 'local') {
            // Simpan video ke storage dan url ke database
            $fileName = uniqid() . '.' . $request->file('link_sumber')->getClientOriginalExtension();
            $request->file('link_sumber')->storeAs('public/videos', $fileName);
            $linkSumber = storage_path('app/public/videos/') . $fileName;
    
            Video::create([
                'judul' => $judul,
                'tipe' => $tipe,
                'link_sumber' => $linkSumber,
            ]);
        }
    
        return redirect()->route('admin.displaysetting')->with('success','Video berhasil ditambahkan');
    }

    public function createBanner(){
        return view('pages.setting.createBanner');
    }

    public function storeBanner(Request $request){
        //melakukan validasi terhadap data yang di inputkan 
        $validator = Validator::make($request->all(),[
            'judul'         => 'required|string|max:255',
            'image_banner'  => 'required|mimes:png,jpg,jpeg|max:2048',
        ]);

        //jika validasi gagal maka akan dikembalikan ke halaman sebelumnya dengan tambahan error
        if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $photo      = $request->file('image_banner');
        $filename   = date('y-m-d').$photo->getClientOriginalName();
        $path       = 'banner/'. $filename;
        Storage::disk('public')->put($path,file_get_contents($photo));

        //mengirimkan data ke database
        
        $data['judul']          = $request->judul;
        $data['image_banner']   = $filename;
        
        //mengirim perintah create ke database
        Banner::create($data);
        return redirect()->route('admin.displaysetting')->with('success','Banner berhasil ditambahkan');
    }
    public function editBanner(Request $request,$id){
        $banner = Banner::find($id);
        return view ('pages.setting.editBanner',compact('banner'));
    }

    public function updateBanner(Request $request,$id){
        //melakukan validasi terhadap data yang di inputkan 
        $validator = Validator::make($request->all(),[
            'judul'         => 'required|string|max:255',
            'image_banner'  => 'required|mimes:png,jpg,jpeg|max:2048',
        ]);

        //jika validasi gagal maka akan dikembalikan ke halaman sebelumnya dengan tambahan error
        if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);
        
        $banner = Banner::find($id);
        
        //mengirimkan data ke database
        $data['judul']          = $request->judul;
        $photo      = $request->file('image_banner');
        if ($photo) {
            $filename   = date('y-m-d').$photo->getClientOriginalName();
            $path       = 'banner/'.$filename;
            
            if ($banner->image) {
                Storage::disk('public')->delete('banner/'.$banner->image_banner);
            }
            Storage::disk('public')->put($path,file_get_contents($photo));

            $data ['image_banner']     = $filename;
        }

        //mengirim perintah create ke database
        if($banner){
            if($banner->update($data)){
                return redirect()->route('admin.displaysetting')->with('success','Berhasil Melakukan Update Banner!');
            } else {
                return redirect()->route('admin.displaysetting')->with('failed','Update Telah Gagal');
            }
        }else {
        return redirect()->route('admin.displaysetting')->with('warning', 'Gambar dengan ID tersebut tidak ditemukan');
        }
    }

    public function deleteBanner(Request $request,$id){
        $banner = Banner::find($id);

        if($banner){
            if($banner->delete()){
                return redirect()->route('admin.displaysetting')->with('success','Banner berhasil dihapus');
            } else {
                return redirect()->route('admin.displaysetting')->with('failed','Penghapusan Gagal');
            }
        }else {
            return redirect()->route('admin.displaysetting')->with('warning', 'Gambar dengan ID tersebut tidak ditemukan');
        }
    }

    public function editFooter(Request $request,$id){
        $data = Footer::find($id);
        return view ('pages.setting.editFooter',compact('data'));
    }

    public function updateFooter(Request $request,$id){
        //melakukan validasi terhadap data yang di inputkan 
        $validator = Validator::make($request->all(),[
            'text'         => 'required|string',
        ]);

        //jika validasi gagal maka akan dikembalikan ke halaman sebelumnya dengan tambahan error
        if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);
        
        $footer = Footer::find($id);
        
        //mengirimkan data ke database
        $data['text']          = $request->text;

        //mengirim perintah create ke database
        if($footer){
            if($footer->update($data)){
                return redirect()->route('admin.displaysetting')->with('success','Berhasil Melakukan Update Footer!');
            } else {
                return redirect()->route('admin.displaysetting')->with('failed','Update Telah Gagal');
            }
        }else {
        return redirect()->route('admin.displaysetting')->with('warning', 'Footer dengan ID tersebut tidak ditemukan');
        }
    }
}
