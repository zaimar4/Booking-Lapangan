<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; 
use App\Models\Lapangan;           
use App\Models\Booking;            // Tambahkan ini
use App\Models\JenisLapangan;      // Sesuaikan dengan nama model Category kamu

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        
    if (config('app.env') === 'production') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Bagikan data ke semua view secara otomatis
        View::composer('*', function ($view) {
            try {
                $view->with([
                    'totalLapangan' => Lapangan::count(),
                    'totalBooking'  => Booking::count(),
                    'totalCategory' => JenisLapangan::count(), // Sesuaikan nama modelnya
                ]);
            } catch (\Exception $e) {
                // Supaya tidak error saat database belum siap/kosong
                $view->with([
                    'totalLapangan' => 0,
                    'totalBooking'  => 0,
                    'totalCategory' => 0,
                ]);
            }
        });
    }
}