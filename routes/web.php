<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\JenisLapanganController;
use App\Http\Controllers\LapanganController;
use App\Http\Controllers\ProfileController;
use App\Models\Lapangan;
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
    Route::get('/dashboard', [LapanganController::class, 'index'])->name('admin.dashboard');
    Route::get('/tambah-lapangan', [LapanganController::class, 'create'])->name('admin.tambah-lapangan');
    Route::post('tambah-lapangan', [LapanganController::class, 'store'])->name('admin.store-lapangan');
    Route::get('/semua-lapangan', [LapanganController::class, 'getAll'])->name('admin.semua-lapangan');

    Route::get('/jenis-lapangan', [JenisLapanganController::class, 'index'])->name('jenis-lapangan');
    Route::get('/tambah', [JenisLapanganController::class, 'create'])->name('tambah-jenis');
    Route::post('/tambah', [JenisLapanganController::class, 'store'])->name('tambah-jenis');
    Route::get('/edit/{lapangan}', [LapanganController::class, 'edit'])->name('edit-lapangan');
    Route::get('/detail/{lapangan}', [LapanganController::class, 'show'])->name('detail-lapangan');
    Route::patch('/update/{lapangan}', [LapanganController::class, 'update'])->name('update-lapangan');
    Route::delete('/delete/{lapangan}', [LapanganController::class, 'destroy'])->name('delete-lapangan');

    Route::get('/daftar-booking', [AdminBookingController::class, 'index'])->name('admin.daftar-booking');
    Route::patch('/booking/{booking}', [AdminBookingController::class, 'update'])->name('admin.booking.update');

});
Route::prefix('user')->middleware(['auth', 'checkrole:user'])->group(function () {
    Route::get('/dashboard', function () {
        return view('user.userdashboard');
    })->name('user.dashboard');
    Route::get('/cari-lapangan', [BookingController::class, 'index'])->name('user.cari-lapangan');
    Route::get('/booking/{lapangan}', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking-saya', [BookingController::class, 'index'])->name('booking.index');
    Route::get('/booking/{lapangan}/create', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::delete('/booking/{booking}', [BookingController::class, 'destroy'])->name('booking.destroy');

});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
