<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JenisLapanganController;
use App\Http\Controllers\LapanganController;
use App\Http\Controllers\LaporanController;
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
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/tambah-lapangan', [LapanganController::class, 'create'])->name('admin.tambah-lapangan');
    Route::post('tambah-lapangan', [LapanganController::class, 'store'])->name('admin.store-lapangan');
    Route::get('/semua-lapangan', [LapanganController::class, 'getAll'])->name('admin.semua-lapangan');
    Route::get('/edit/{lapangan}', [LapanganController::class, 'edit'])->name('edit-lapangan');
    Route::get('/detail/{lapangan}', [LapanganController::class, 'show'])->name('detail-lapangan');
    Route::delete('/delete/{lapangan}', [LapanganController::class, 'destroy'])->name('delete-lapangan');
    Route::patch('/update/{lapangan}', [LapanganController::class, 'update'])->name('update-lapangan');

    Route::get('/jenis-lapangan', [JenisLapanganController::class, 'index'])->name('jenis-lapangan');
    Route::get('/tambah', [JenisLapanganController::class, 'create'])->name('tambah-jenis');
    Route::post('/tambah', [JenisLapanganController::class, 'store'])->name('store-jenis');
    Route::delete('/jenis-lapangan/{jenisLapangan}', [JenisLapanganController::class, 'destroy'])->name('hapus-jenis');

    Route::get('/daftar-booking', [AdminBookingController::class, 'index'])->name('admin.daftar-booking');
    Route::patch('/booking/{booking}', [AdminBookingController::class, 'update'])->name('admin.booking.update');

    Route::get('/admin/laporan', [LaporanController::class, 'index'])
    ->name('laporan.index');

    Route::get('/admin/laporan/pendapatan/pdf', [LaporanController::class, 'exportPendapatan'])
    ->name('laporan.pendapatan.pdf');

    Route::get('/admin/laporan/booking/pdf', [LaporanController::class, 'exportBooking'])
    ->name('laporan.booking.pdf');
  

});
Route::prefix('user')->middleware(['auth', 'checkrole:user'])->group(function () {
    Route::get('/dashboard', function () {
        $userId = Auth::id();

        $totalBooking = \App\Models\Booking::where('user_id', $userId)->count();
        $totalPending = \App\Models\Booking::where('user_id', $userId)->where('status', 'pending')->count();
        $totalConfirmed = \App\Models\Booking::where('user_id', $userId)->where('status', 'confirmed')->count();
        $totalCompleted = \App\Models\Booking::where('user_id', $userId)->where('status', 'completed')->count();

        $bookingTerbaru = \App\Models\Booking::with('lapangan')
            ->where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        return view('user.userdashboard', compact(
            'totalBooking',
            'totalPending',
            'totalConfirmed',
            'totalCompleted',
            'bookingTerbaru'
        ));
    })->name('user.dashboard');
    Route::get('/cari-lapangan', [LapanganController::class, 'getAll'])->name('user.cari-lapangan');
    Route::get('/detail-lapangan/{lapangan}', [LapanganController::class, 'show'])->name('user.detail-lapangan');
    Route::delete('/booking/{booking}', [BookingController::class, 'destroy'])->name('booking.destroy');
    Route::get('/booking/{lapangan}', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking-saya', [BookingController::class, 'index'])->name('booking.index');
      Route::get(
    '/booking/slots/{lapangan}/{tanggal}',
    [BookingController::class, 'getBookedSlots']
    );

});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
