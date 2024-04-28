<?php

namespace App\Http\Controllers;

use App\Models\Loket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function __construct(){
        $this->middleware(['role_or_permission:employee|view_admin']);
        }

    public function dashboardEmployee(Request $request)
{
    $userId = Auth::user()->id; // Dapatkan user id saat login
    $loket = Loket::where('user_id', $userId)->first(); // Cari loket berdasarkan user id

    if (!$loket) {
        // Handle error jika loket tidak ditemukan
        return redirect()->back()->withError('Loket tidak ditemukan');
    }

    $data = $loket; // Simpan data loket dalam variabel $data

    return view('pages.employee.dashboard', compact('data')); // Kembalikan view dengan data loket
}
}
