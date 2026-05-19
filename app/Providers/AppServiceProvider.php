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

    View::composer('admin.admindashboard', function ($view) {
        
        $statistik = Cache::remember('admin_stats', 600, function () {
            return [
                'totalLapangan'     => Lapangan::count(),
                'totalBookingSemua' => Booking::count(),
                'bookingPending'    => Booking::where('status', 'pending')->count(),
            ];
        });

        // Kirim data yang sudah di-cache ke view
        $view->with($statistik);
    });
}
}


