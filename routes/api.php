<?php

use App\Http\Controllers\AntrianController;
use App\Http\Controllers\DisplayController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/createForm/{id}',[AntrianController::class,'createAntrian'])->name('form.create');
Route::get('/ip-server',[DisplayController::class,'getIP'])->name('IPServer');

