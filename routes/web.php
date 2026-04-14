<?php

use App\Http\Controllers\JenisLapanganController;
use App\Http\Controllers\LapanganController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {

    $role = Auth::user()->role;

    if ($role === 'admin') {
        return redirect('/admin/dashboard');
    }

    if ($role === 'user') {
        return redirect('/user/dashboard');
    }
    abort(403);

})->middleware(['auth'])->name('dashboard');

Route::prefix('admin')->middleware(['auth', 'checkrole:admin'])->group(function () {
    Route::get('/dashboard', [LapanganController::class,'index'])->name('admin.dashboard');
    Route::get('/tambah-lapangan',[LapanganController::class,'create'])->name('admin.tambah-lapangan');
    Route::post('tambah-lapangan',[LapanganController::class,'store'])->name('admin.store-lapangan');

    Route::get('/jenis-lapangan',[JenisLapanganController::class,'index'])->name('jenis-lapangan');
    Route::get('/tambah',[JenisLapanganController::class,'create'])->name('tambah-jenis');
    Route::post('/tambah',[JenisLapanganController::class,'store'])->name('tambah-jenis');
});
Route::prefix('user')->middleware(['auth', 'checkrole:user'])->group(function () {
    Route::get('/dashboard', function () {
        return view('user.userdashboard');
    })->name('user.dashboard');
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
