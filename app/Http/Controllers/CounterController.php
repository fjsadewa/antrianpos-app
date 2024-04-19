<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CounterController extends Controller
{
    public function dashboardCounter(){
        return view ('pages.counter.dashboard');
    }
}
