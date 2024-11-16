<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudioController;
use App\Http\Controllers\StudioReservationController;
use App\Http\Controllers\UserController;


Route::get('/', function () {
    return redirect('dashboard');
});

//breezeインストール時に生成されたルート
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


//ログインが必要なページのルートはここに実装
Route::middleware('auth')->group(function () {
    //アカウント周り（breezeで自動実装）
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //usersの操作（管理者）
    Route::resource("/users", UserController::class);
    Route::patch('users/{user}/toggle-admin', [UserController::class, 'toggleAdmin'])->name('users.toggleAdmin');



    Route::resource('studios', StudioController::class)->only(['index','store', 'update', 'destroy']);
    Route::resource("/reservations", StudioReservationController::class);
});


require __DIR__ . '/auth.php';
