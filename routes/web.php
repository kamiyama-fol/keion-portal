<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudioController;

Route::get('/', function () {
    return redirect('dashboard');
});

//breezeインストール時に生成されたルート
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


//ログインが必要なページのルートはここに実装
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //StudioControllerのルーティング
    Route::get("/studio", [StudioController::class, 'show'])->name('studio');
    Route::resource('band', "BandController");
});


require __DIR__ . '/auth.php';
