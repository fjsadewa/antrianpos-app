<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CounterController extends Controller
{

    public function __construct(){
        $this->middleware(['role_or_permission:employee|view_admin']);
        }

    public function dashboardCounter(Request $request,$id){ 

        $data = User::find($id);

        return view ('pages.counter.dashboard',compact('data'));
    }
}
