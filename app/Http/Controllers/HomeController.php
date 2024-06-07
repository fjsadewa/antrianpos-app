<?php

namespace App\Http\Controllers;

use App\Models\addText;
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
        $video = Video::get();
        $banner = Banner::get();
        $footer = Footer::get();
        return view('pages.setting.displayset',compact('video','banner','footer'));
    }

    public function createVideo(){
        return view('pages.setting.createVideo');
    }

    public function storeVideo(Request $request){
        $tipe = $request->get('tipe');
        if ($tipe === 'youtube') {
            $this->validate($request, [
                'judul' => 'required|string|max:255',
                'tipe'  => 'required|in:youtube,local',
                'link'  => 'required_if:tipe,youtube|url|nullable',
            ]);
        } else {
            $this->validate($request, [
                'judul' => 'required|string|max:255',
                'tipe'  => 'required|in:youtube,local',
                'customFile' => 'required_if:tipe,local|file|mimes:mp4,avi',
            ]);
        }
        $videoData = [];
        if ($request->tipe === 'youtube') {
            $videoData['judul']= $request->judul;
            $videoData['tipe']= $request->tipe;
            $videoData['link_sumber'] = $request->link;
        } else {
            if (!is_dir('banner')) {
                mkdir('banner', 0755, true);
            }
            $videoData['judul']= $request->judul;
            $videoData['tipe']= $request->tipe;
            $videoData['link_sumber'] = $request->file('customFile')->getClientOriginalName(); 
            $vid = $request->file('customFile')->getClientOriginalName();
            $destinationPath = public_path().'/video';
            $request->file('customFile')->move($destinationPath,$vid);
        }
    
        Video::create($videoData);
    
        return redirect()->route('admin.displaysetting')->with('success','Video berhasil ditambahkan');
    }

    public function editVideo(Request $request,$id){
        $video = Video::find($id);
        return view ('pages.setting.editVideo',compact('video'));
    }

    public function updateVideo(Request $request, $id){
        $video = Video::find($id);

        if (!$video) {
            return redirect()->route('admin.video.index')->with('error', 'Video tidak ditemukan');
        }

        $this->validate($request, [
            'judul' => 'required|string|max:255',
            'link' => 'required_if:tipe,youtube|url', 
            'customFile' => 'nullable|file|mimes:mp4,avi', 
        ]);

        if ($request->tipe === 'youtube') {
            // Update Youtube video
            $videoData = [
                'judul' => $request->judul,
                'link_sumber' => $request->link
            ];
        } else {
            // Update local video
            $videoData = [
                'judul' => $request->judul,
            ];
        
            if ($request->hasFile('customFile')) {
                if (!is_dir('video')) {
                    mkdir('video', 0755, true);
                }
                if ($video->tipe === 'local') {
                    $videoPath = 'video/' . $video->link_sumber;
                    if (file_exists($videoPath)) {
                        unlink($videoPath);
                    }
                }
                $videoData['link_sumber'] = $request->file('customFile')->getClientOriginalName();
                $vid = $request->file('customFile')->getClientOriginalName();
                $destinationPath = public_path().'/video';
                $request->file('customFile')->move($destinationPath,$vid);
            } else if ($video->tipe === 'local') {
                $videoData['link_sumber'] = $video->link_sumber;
            }
        }
        // dd($videoData);
        if($video->update($videoData)){
            return redirect()->route('admin.displaysetting')->with('success','Berhasil Melakukan Update Video!');
        } else {
            return redirect()->route('admin.displaysetting')->with('failed','Update Telah Gagal');
        }
    }

    public function deleteVideo($id){
        $video = Video::find($id);
        if (!$video) {
            return redirect()->route('admin.displaysetting')->with('warning', 'Banner dengan ID tersebut tidak ditemukan');
        }

        if ($video->tipe === 'local') {
            $videoPath = 'video/' . $video->link_sumber;
            if (file_exists($videoPath)) {
                unlink($videoPath);
            }
        }
        
        if($video->delete()){
            return redirect()->route('admin.displaysetting')->with('success','Video berhasil dihapus');
        } else {
            return redirect()->route('admin.displaysetting')->with('failed','Penghapusan Gagal');
        }
        
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

        // $photo      = $request->file('image_banner');
        // $filename   = date('y-m-d').$photo->getClientOriginalName();
        // $path       = 'banner/'. $filename;
        // Storage::disk('public')->put($path,file_get_contents($photo));

        $photo = $request->file('image_banner');
        if (!is_dir('banner')) {
            mkdir('banner', 0755, true);
        }

        // Mengubah nama file
        $filename = date('Ymd') . $photo->getClientOriginalName();

        $destinationPath = public_path().'/banner';
        $photo->move($destinationPath,$filename);

        $data['judul']          = $request->judul;
        $data['image_banner']   = $filename;
        
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

        if (!$banner) {
            return redirect()->route('admin.displaysetting')->with('warning', 'Banner dengan ID tersebut tidak ditemukan');
        }
        //mengirimkan data ke database
        $data['judul']  = $request->judul;
        $photo          = $request->file('image_banner');

        if ($photo) {
            
            if ($banner->image_banner) {
                $imagePath = 'banner/' . $banner->image_banner;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            $filename = date('Ymd') . $photo->getClientOriginalName();

    
            $destinationPath = public_path().'/banner';
            $photo->move($destinationPath,$filename);

            $data['image_banner'] = $filename;
        }

        if($banner->update($data)){
            return redirect()->route('admin.displaysetting')->with('success','Berhasil Melakukan Update Banner!');
        } else {
            return redirect()->route('admin.displaysetting')->with('failed','Update Telah Gagal');
        }
    }

    public function deleteBanner($id){
        $banner = Banner::find($id);
        if (!$banner) {
            return redirect()->route('admin.displaysetting')->with('warning', 'Banner dengan ID tersebut tidak ditemukan');
        }

        if ($banner->image_banner) {
            $imagePath = 'banner/' . $banner->image_banner;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        // if($banner){
        if($banner->delete()){
            return redirect()->route('admin.displaysetting')->with('success','Banner berhasil dihapus');
        } else {
            return redirect()->route('admin.displaysetting')->with('failed','Penghapusan Gagal');
        }
        // }
    }

    public function editFooter(Request $request,$id){
        $data = Footer::find($id);
        return view ('pages.setting.editFooter',compact('data'));
    }

    public function updateFooter(Request $request,$id){
        //melakukan validasi terhadap data yang di inputkan 
        $validator = Validator::make($request->all(),[
            'text'         => 'required|string|max:255',
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

    public function printSet(){
        $text = addText::get();
        return view('pages.setting.printerSet',compact('text'));
    }

    public function editText(Request $request,$id){
        $data = addText::find($id);
        return view ('pages.setting.editText',compact('data'));
    }

    public function updateText(Request $request,$id){
        //melakukan validasi terhadap data yang di inputkan 
        $validator = Validator::make($request->all(),[
            'text'         => 'required|string|max:100',
        ]);

        //jika validasi gagal maka akan dikembalikan ke halaman sebelumnya dengan tambahan error
        if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);
        
        $text = addText::find($id);
        
        //mengirimkan data ke database
        $data['text']          = $request->text;

        //mengirim perintah create ke database
        if($text){
            if($text->update($data)){
                return redirect()->route('admin.printSet')->with('success','Berhasil Melakukan Update Text!');
            } else {
                return redirect()->route('admin.printSet')->with('failed','Update Telah Gagal');
            }
        }else {
        return redirect()->route('admin.printSet')->with('warning', 'Text tersebut tidak ditemukan');
        }
    }
}
