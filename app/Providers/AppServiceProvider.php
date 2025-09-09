<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use App\Models\VisitorCounter;
use Illuminate\Support\ServiceProvider;

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
        // Bagikan data visitor ke semua view
        View::composer('*', function ($view) {
            // Ambil data counter. Jika belum ada, anggap 0.
            $counter = VisitorCounter::find(1);
            $count = $counter ? $counter->count : 0;

            // Format angka (misal: 2100 menjadi 2.1K)
            if ($count >= 1000) {
                $visitorCount = round($count / 1000, 1) . 'K';
            } else {
                $visitorCount = $count;
            }

            $view->with('visitorCount', $visitorCount);
        });
    }
}
