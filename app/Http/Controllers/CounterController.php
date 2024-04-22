<?php

namespace App\Http\Controllers;

use App\Models\KategoriPelayanan;
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

        return redirect()->route('admin.category');
    }

    public function editCategory(Request $request,$id){
        $data_category = KategoriPelayanan::find($id);

        return view ('pages.categories.edit',compact('data_category'));
    }

    public function updateCategory(Request $request,$id){
        //melakukan validasi terhadap data yang di inputkan 
        $validator = Validator::make($request->all(),[
            'kode_pelayanan'        => 'required|max:3|unique:kategori_pelayanans,kode_pelayanan',
            'nama_pelayanan'        => 'required',
            'deskripsi'             => 'nullable',
        ]);

        //jika validasi gagal maka akan dikembalikan ke halaman sebelumnya dengan tambahan error
        if($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);
        
        $find = KategoriPelayanan::find($id);
        //mengirimkan data ke database
        $data_category['kode_pelayanan']    = $request->kode_pelayanan;
        $data_category['nama_pelayanan']    = $request->nama_pelayanan;
        $data_category['deskripsi']         = $request->deskripsi;

        //mengirim perintah create ke database

        $data_category = KategoriPelayanan::find($id);

        if($data_category){
            if($data_category->update()){
                return redirect()->route('admin.category')->with('success','Berhasil Melakukan Update! ');
            } else {
                return redirect()->route('admin.category')->with('failed','Update gagal Gagal');
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
        return view ('pages.counter.main');
    }
}
