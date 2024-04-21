<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DisplayController extends Controller
{
    public function display(){
        return view('pages.display');
    }

    public function form(){
        return view('pages.form');
    }
}
