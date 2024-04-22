<?php

use App\Http\Controllers\CounterController;
use App\Http\Controllers\DisplayController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;

Route::get('/login',[LoginController::class,'login'])->name('login');
Route::post('/login_process',[LoginController::class,'login_process'])->name('login_process');
Route::get('/logout',[LoginController::class,'logout'])->name('logout');

Route::get('/display',[DisplayController::class,'display'])->name('display');
Route::get('/form',[DisplayController::class,'form'])->name('form');

Route::group(['prefix'=>'admin','middleware'=> ['auth'],'as'=> 'admin.'], function(){
    Route::get('/dashboard',[HomeController::class,'dashboard'])->name('dashboard');
    Route::get('/user',[HomeController::class,'user'])->name('user');
    
    Route::get('/create',[HomeController::class,'createUser'])->name('user.create');
    Route::post('/store',[HomeController::class,'store'])->name('user.store');
    Route::get('/edit/{id}',[HomeController::class,'edit'])->name('user.edit');
    Route::put('/update/{id}',[HomeController::class,'update'])->name('user.update');
    Route::delete('/delete/{id}',[HomeController::class,'delete'])->name('user.delete');
    
    Route::get('/displaysetting',[HomeController::class,'displaySetting'])->name('displaysetting');
    
    Route::get('/category',[CounterController::class,'category'])->name('category');
    Route::get('/createCategory',[CounterController::class,'createCategory'])->name('category.create');
    Route::post('/storeCategory',[CounterController::class,'storeCategory'])->name('category.store');
    Route::get('/editCategory/{id}',[CounterController::class,'editCategory'])->name('category.edit');
    Route::put('/updateCategory/{id}',[CounterController::class,'updateCategory'])->name('category.update');
    Route::delete('/deleteCategory/{id}',[CounterController::class,'deleteCategory'])->name('category.delete');

    Route::get('/counter',[CounterController::class,'counter'])->name('counter');

});

Route::group(['prefix'=>'employee','middleware'=> ['auth'],'as'=> 'employee.'], function(){
    Route::get('/dashboard-employee/{id}',[EmployeeController::class,'dashboardEmployee'])->name('dashboardEmployee');
});
