<?php

namespace App\Providers;

use App\Models\IbuHamil;
use App\Observers\IbuHamilObserver;
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
        IbuHamil::observe(IbuHamilObserver::class);
    }
}
