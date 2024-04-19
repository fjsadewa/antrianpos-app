<?php

use App\Http\Controllers\CounterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;

Route::get('/login',[LoginController::class,'login'])->name('login');
Route::post('/login_process',[LoginController::class,'login_process'])->name('login_process');
Route::get('/logout',[LoginController::class,'logout'])->name('logout');

Route::get('/display',[HomeController::class,'display'])->name('display');
Route::get('/form',[HomeController::class,'form'])->name('form');

Route::group(['prefix'=>'admin','middleware'=> ['auth'],'as'=> 'admin.'], function(){
    Route::get('/dashboard',[HomeController::class,'dashboard'])->name('dashboard');
    Route::get('/user',[HomeController::class,'user'])->name('user');
    
    Route::get('/create',[HomeController::class,'createUser'])->name('user.create');
    Route::post('/store',[HomeController::class,'store'])->name('user.store');
    
    Route::get('/edit/{id}',[HomeController::class,'edit'])->name('user.edit');
    Route::put('/update/{id}',[HomeController::class,'update'])->name('user.update');
    
    Route::delete('/delete/{id}',[HomeController::class,'delete'])->name('user.delete');
});


Route::get('/counter',[CounterController::class,'dashboardCounter'])->name('dashboardCounter');
