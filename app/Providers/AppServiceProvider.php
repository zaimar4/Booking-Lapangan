<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache; 
use App\Models\Lapangan;
use App\Models\Booking;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    
public function boot(): void
{
    if (config('app.env') === 'production') {
        URL::forceScheme('https');
    }

// Menggunakan 'admin.*' agar otomatis dibagikan ke 'admin.admindashboard' DAN 'admin.detail'
View::composer(['admin.admindashboard', 'admin.*'], function ($view) {
    
    $statistik = Cache::remember('admin_stats_v2', 600, function () {
        return [
            'totalLapangan'        => \App\Models\Lapangan::count(),
            'totalBookingSemua'    => \App\Models\Booking::count(),
            'bookingPending'       => \App\Models\Booking::where('status', 'pending')->count(),
            
            'totalPendapatanSemua' => \App\Models\Booking::join('lapangans', 'lapangans.id', '=', 'bookings.lapangan_id')
                ->whereIn('bookings.status', ['confirmed', 'completed'])
                ->selectRaw('SUM(lapangans.harga_sewa * TIMESTAMPDIFF(HOUR, bookings.jam_mulai, bookings.jam_selesai)) as total')
                ->value('total') ?? 0,
        ];
    });

    $view->with($statistik);
});
}
}


