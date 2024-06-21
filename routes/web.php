<?php

use App\Http\Controllers\AntrianController;
use App\Http\Controllers\CounterController;
use App\Http\Controllers\DisplayController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Storage;

Route::get('/login',[LoginController::class,'login'])->name('login');
Route::post('/login_process',[LoginController::class,'login_process'])->name('login_process');
Route::get('/logout',[LoginController::class,'logout'])->name('logout');

Route::get('/display',[DisplayController::class,'display'])->name('display');
Route::get('/displayView',[DisplayController::class,'displayView'])->name('displayView');
Route::get('/form',[DisplayController::class,'form'])->name('form');
Route::get('/footer',[DisplayController::class,'getFooter'])->name('footer');
Route::get('/img',[DisplayController::class,'getBanner']);
Route::get('/vid',[DisplayController::class,'getVideo']);
// Route::get('/icon/{filename}', function ($filename) {
//     $path = 'icon-category/' . $filename;
//     if (Storage::disk('public')->exists($path)) {
//         $image = Storage::disk('public')->get($path);
//         return response($image, 200, [
//             'Content-Type' => 'image/jpeg', // Ubah sesuai jenis gambar
//         ]);
//     } else {
//         return response()->json(['error' => 'Gambar tidak ditemukan'], 404);
//     }
// });
Route::get('/icon/{filename}', function ($filename) {
    $path = 'icon-category/' . $filename;
    if (file_exists(public_path($path))) {
        $image = file_get_contents(public_path($path));
        return response($image, 200, [
            'Content-Type' => 'image/jpeg',
        ]);
    } else {
        return response()->json(['error' => 'Gambar tidak ditemukan'], 404);
    }
});
// Route::get('/profile/{filename}', function ($filename) {
//     $path = 'photo-profile/' . $filename;
//     if (Storage::disk('public')->exists($path)) {
//         $image = Storage::disk('public')->get($path);
//         return response($image, 200, [
//             'Content-Type' => 'image/jpeg', 
//         ]);
//     } else {
//         return response()->json(['error' => 'Gambar tidak ditemukan'], 404);
//     }
// });
Route::get('/profile/{filename}', function ($filename) {
    $path = 'photo-profile/' . $filename;
    if (file_exists(public_path($path))) {
        $image = file_get_contents(public_path($path));
        return response($image, 200, [
            'Content-Type' => 'image/jpeg',
        ]);
    } else {
        return response()->json(['error' => 'Gambar tidak ditemukan'], 404);
    }
});

Route::get('/getAntrian',[AntrianController::class, 'getAntrian']);

Route::group(['prefix'=>'admin','middleware'=> ['auth'],'as'=> 'admin.'], function(){
    Route::get('/dashboard',[HomeController::class,'dashboard'])->name('dashboard');
    Route::get('/user',[HomeController::class,'user'])->name('user');
    
    Route::get('/create',[HomeController::class,'createUser'])->name('user.create');
    Route::post('/store',[HomeController::class,'store'])->name('user.store');
    Route::get('/edit/{id}',[HomeController::class,'edit'])->name('user.edit');
    Route::put('/update/{id}',[HomeController::class,'update'])->name('user.update');
    Route::delete('/delete/{id}',[HomeController::class,'delete'])->name('user.delete');
    
    Route::get('/displaysetting',[HomeController::class,'displaySetting'])->name('displaysetting');
    Route::get('/createVideo',[HomeController::class,'createVideo'])->name('video.create');
    Route::post('/storeVideo',[HomeController::class,'storeVideo'])->name('video.store');
    Route::get('/editVideo/{id}',[HomeController::class,'editVideo'])->name('video.edit');
    Route::put('/updateVideo/{id}',[HomeController::class,'updateVideo'])->name('video.update');
    Route::delete('/deleteVideo/{id}',[HomeController::class,'deleteVideo'])->name('video.delete');
    
    Route::get('/createaBanner',[HomeController::class,'createBanner'])->name('banner.create');
    Route::post('/storeBanner',[HomeController::class,'storeBanner'])->name('banner.store');
    Route::get('/editBanner/{id}',[HomeController::class,'editBanner'])->name('banner.edit');
    Route::put('/updateBanner/{id}',[HomeController::class,'updateBanner'])->name('banner.update');
    Route::delete('/deleteBanner/{id}',[HomeController::class,'deleteBanner'])->name('banner.delete');

    Route::get('/editFooter/{id}',[HomeController::class,'editFooter'])->name('footer.edit');
    Route::put('/updateFooter/{id}',[HomeController::class,'updateFooter'])->name('footer.update');

    Route::put('/updateDisplaySet',[HomeController::class,'updateDisplaySet'])->name('setting.update');
    
    Route::get('/printSet',[HomeController::class,'printSet'])->name('printSet');
    Route::get('/editText/{id}',[HomeController::class,'editText'])->name('text.edit');
    Route::put('/updateText/{id}',[HomeController::class,'updateText'])->name('text.update');
    
    Route::get('/category',[CounterController::class,'category'])->name('category');
    Route::get('/createCategory',[CounterController::class,'createCategory'])->name('category.create');
    Route::post('/storeCategory',[CounterController::class,'storeCategory'])->name('category.store');
    Route::get('/editCategory/{id}',[CounterController::class,'editCategory'])->name('category.edit');
    Route::put('/updateCategory/{id}',[CounterController::class,'updateCategory'])->name('category.update');
    Route::delete('/deleteCategory/{id}',[CounterController::class,'deleteCategory'])->name('category.delete');

    Route::get('/counter',[CounterController::class,'counter'])->name('counter');
    Route::get('/createCounter',[CounterController::class,'createCounter'])->name('counter.create');
    Route::post('/storeCounter',[CounterController::class,'storeCounter'])->name('counter.store');
    Route::get('/editCounter/{id}',[CounterController::class,'editCounter'])->name('counter.edit');
    Route::put('/updateCounter/{id}',[CounterController::class,'updateCounter'])->name('counter.update');
    Route::delete('/deleteCounter/{id}',[CounterController::class,'deleteCounter'])->name('counter.delete');
    
    Route::get('/move',[HomeController::class,'moveData'])->name('moveData');
});

Route::group(['prefix'=>'employee','middleware'=> ['auth'],'as'=> 'employee.'], function(){
    Route::get('/dashboard-employee/{id}',[EmployeeController::class,'dashboardEmployee'])->name('dashboardEmployee');
    Route::get('/dashboard-employee/{id}/getAntrian',[EmployeeController::class,'getAntrian'])->name('getAntrian');
    Route::post('/dashboard-employee/{id}/panggilAntrian',[EmployeeController::class,'panggilAntrian'])->name('panggilAntrian');
    Route::post('/dashboard-employee/{id}/lewatiAntrian',[EmployeeController::class,'lewatiAntrian'])->name('lewatiAntrian');
    Route::post('/dashboard-employee/{id}/mulaiAntrian',[EmployeeController::class,'mulaiAntrian'])->name('mulaiAntrian');
    Route::post('/dashboard-employee/{id}/selesai',[EmployeeController::class,'selesai'])->name('selesai');

    Route::get('/history/{id}',[EmployeeController::class,'history'])->name('locket.history');

});

Route::get('/datatable/antrianSekarangData',[EmployeeController::class,'antrianSekarangData'])->name('antrianSekarangData');
Route::get('/datatable/antrianData',[EmployeeController::class,'antrianData'])->name('antrianData');

