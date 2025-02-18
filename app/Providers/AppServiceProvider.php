<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Estadistica;
use App\Observers\EstadisticaObserver;  // Add this line

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
    public function boot()
    {
        Estadistica::observe(EstadisticaObserver::class);
    }
}
