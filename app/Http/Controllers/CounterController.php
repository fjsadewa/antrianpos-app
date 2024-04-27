<?php

namespace App\Http\Controllers;

use App\Models\KategoriPelayanan;
use App\Models\Loket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CounterController extends Controller
{

    public function __construct(){
        $this->middleware(['role:admin','permission:view_admin']);
    }

    public function category (){
        $data_category  = KategoriPelayanan::get();
        return view ('pages.categories.main', compact('data_category'));
    }

    public function createCategory(){
        return view('pages.categories.create');
    }

    public function storeCategory(Request $request){
        //melakukan validasi terhadap data yang di inputkan 
        $validator = Validator::make($request->all(),[
            'kode_pelayanan'        => 'required|max:3|unique:kategori_pelayanans,kode_pelayanan',
            'nama_pelayanan'        => 'required',
            'deskripsi'             => 'nullable',
        ]);

        //jika validasi gagal maka akan dikembalikan ke halaman sebelumnya dengan tambahan error
        if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        //mengirimkan data ke database
        $data_category['kode_pelayanan']    = $request->kode_pelayanan;
        $data_category['nama_pelayanan']    = $request->nama_pelayanan;
        $data_category['deskripsi']         = $request->deskripsi;

        //mengirim perintah create ke database
        KategoriPelayanan::create($data_category);

        return redirect()->route('admin.category')->with('success','Kategori berhasil ditambahkan');
    }

    public function editCategory(Request $request,$id){
        $data_category = KategoriPelayanan::find($id);

        return view ('pages.categories.edit',compact('data_category'));
    }

    public function updateCategory(Request $request,$id){
        //melakukan validasi terhadap data yang di inputkan 
        $validator = Validator::make($request->all(),[
            'kode_pelayanan'        => 'required|max:3|unique:kategori_pelayanans,kode_pelayanan,'.$request->id.',id',
            'nama_pelayanan'        => 'required',
            'deskripsi'             => 'nullable',
        ]);

        //jika validasi gagal maka akan dikembalikan ke halaman sebelumnya dengan tambahan error
        if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);
        
        //mengirimkan data ke database
        $data_category['kode_pelayanan']    = $request->kode_pelayanan;
        $data_category['nama_pelayanan']    = $request->nama_pelayanan;
        $data_category['deskripsi']         = $request->deskripsi;
        
        //mengirim perintah create ke database
        
        $data = KategoriPelayanan::find($id);
        
        if($data){
            if($data->update($data_category)){
                return redirect()->route('admin.category')->with('success','Berhasil Melakukan Update! ');
            } else {
                return redirect()->route('admin.category')->with('failed','Update Telah Gagal');
            }
        }else {
        return redirect()->route('admin.category')->with('warning', 'User dengan ID tersebut tidak ditemukan');
        }
    }

    public function deleteCategory(Request $request,$id){
        $data_category = KategoriPelayanan::find($id);

        if($data_category){
            if($data_category->delete()){
                return redirect()->route('admin.category')->with('success','Kategori berhasil dihapus');
            } else {
                return redirect()->route('admin.category')->with('failed','Penghapusan Gagal');
            }
        }else {
            return redirect()->route('admin.category')->with('warning', 'Kategori dengan ID tersebut tidak ditemukan');
        }
    }

    public function counter (){
        $data_counter = Loket::get();
        return view ('pages.counter.main',compact('data_counter'));
    }

    public function createCounter(){
        $categories = KategoriPelayanan::get();
        $user = User::Role('employee')->get();

        return view('pages.counter.create',compact('categories','user'));
    }

    public function storeCounter(Request $request){
        //melakukan validasi terhadap data yang di inputkan 
        $validator = Validator::make($request->all(),[
            'nomor_loket'           => 'required|integer|unique:lokets,nomor_loket',
            'status'                => 'required|in:terbuka,tertutup',
            'kategori_pelayanan_id' => 'required|integer|exists:kategori_pelayanans,id',
            'user_id'               => 'required|integer|exists:users,id|unique:lokets,user_id,'.$request->id.',id'
        ]);

        //jika validasi gagal maka akan dikembalikan ke halaman sebelumnya dengan tambahan error
        if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        //mengirimkan data ke database
        $data_counter['nomor_loket']            = $request->nomor_loket;
        $data_counter['status']                 = $request->status;
        $data_counter['kategori_pelayanan_id']  = $request->kategori_pelayanan_id;
        $data_counter['user_id']                = $request->user_id;

        //mengirim perintah create ke database
        Loket::create($data_counter);
        return redirect()->route('admin.counter')->with('success','Loket berhasil ditambahkan');
    }

    public function editCounter(Request $request,$id){
        $categories = KategoriPelayanan::get();
        $user = User::Role('employee')->get();
        $data_counter = Loket::find($id);
        return view ('pages.counter.edit',compact('data_counter','categories','user'));
    }


    public function updateCounter(Request $request, $id){
        //melakukan validasi terhadap data yang di inputkan 
        $validator = Validator::make($request->all(),[
            'nomor_loket'           => 'required|integer|unique:lokets,nomor_loket,'.$request->id.',id',
            'status'                => 'required|in:terbuka,tertutup',
            'kategori_pelayanan_id' => 'required|integer|exists:kategori_pelayanans,id',
            'user_id'               => 'required|integer|exists:users,id|unique:lokets,user_id,'.$request->id.',id'
        ]);

        //jika validasi gagal maka akan dikembalikan ke halaman sebelumnya dengan tambahan error
        if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $data_counter['nomor_loket']            = $request->nomor_loket;
        $data_counter['status']                 = $request->status;
        $data_counter['kategori_pelayanan_id']  = $request->kategori_pelayanan_id;
        $data_counter['user_id']                = $request->user_id;

        $data = Loket::find($id);

        if($data){
            if($data->update($data_counter)){
                return redirect()->route('admin.counter')->with('success','Berhasil Melakukan Update! ');
            } else {
                return redirect()->route('admin.counter')->with('failed','Update Telah Gagal');
            }
        }else {
        return redirect()->route('admin.counter')->with('warning', 'User dengan ID tersebut tidak ditemukan');
        }
    }

    public function deleteCounter(Request $request,$id){
        $data_counter = Loket::find($id);

        if($data_counter){
            if($data_counter->delete()){
                return redirect()->route('admin.counter')->with('success','Kategori berhasil dihapus');
            } else {
                return redirect()->route('admin.counter')->with('failed','Penghapusan Gagal');
            }
        }else {
            return redirect()->route('admin.counter')->with('warning', 'Kategori dengan ID tersebut tidak ditemukan');
        }
    }
}
