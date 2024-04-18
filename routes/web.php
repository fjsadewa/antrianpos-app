<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/dashboard',[HomeController::class,'dashboard'])->name('dashboard');
Route::get('/user',[HomeController::class,'user'])->name('user');

Route::get('/create',[HomeController::class,'createUser'])->name('user.create');
Route::post('/store',[HomeController::class,'store'])->name('user.store');

Route::get('/edit/{id}',[HomeController::class,'edit'])->name('user.edit');
Route::put('/update/{id}',[HomeController::class,'update'])->name('user.update');

Route::delete('/delete/{id}',[HomeController::class,'delete'])->name('user.delete');