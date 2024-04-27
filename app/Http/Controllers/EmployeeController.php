<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function __construct(){
        $this->middleware(['role_or_permission:employee|view_admin']);
        }

    public function dashboardEmployee(Request $request,$id){ 

        $data = User::find($id);
        return view ('pages.employee.dashboard',compact('data'));
    }
}
