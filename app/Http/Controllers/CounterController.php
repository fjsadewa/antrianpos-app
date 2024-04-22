<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CounterController extends Controller
{
    public function category (){
        return view ('pages.categories.main');
    }

    public function counter (){
        return view ('pages.counter.main');
    }
}
