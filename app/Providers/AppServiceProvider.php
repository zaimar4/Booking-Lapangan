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

    // 1. Ganti '*' menjadi view yang benar-benar membutuhkan data ini saja
    // Pastikan nama view/component sesuai dengan file kamu (misal: layouts.layout atau components.sidenavbar)
    View::composer(['layouts.layout', 'components.sidenavbar'], function ($view) {
        try {
            // 2. Gunakan Cache agar tidak hit database setiap detik
            // Data akan disimpan di memori selama 5 menit (300 detik)
            $stats = cache()->remember('admin_sidebar_stats', 300, function () {
                return [
                    'totalLapangan' => Lapangan::count(),
                    'totalBooking'  => Booking::count(),
                    'totalCategory' => JenisLapangan::count(),
                ];
            });

            $view->with($stats);
        } catch (\Exception $e) {
            $view->with([
                'totalLapangan' => 0,
                'totalBooking'  => 0,
                'totalCategory' => 0,
            ]);
        }
    });
}
}