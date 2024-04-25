<?php

namespace App\Http\Controllers;

use App\Models\KategoriPelayanan;
use Illuminate\Http\Request;

class DisplayController extends Controller
{
    public function display(){
        
        return view('pages.display');
    }

    public function form(){
        $kategoriLayanan = KategoriPelayanan::get();
        return view('pages.form',compact('kategoriLayanan'));
    }
}
