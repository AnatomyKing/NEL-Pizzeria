<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Hier kun je eventuele bindingen of services registreren als dat nodig is
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Beperkt de standaard stringlengte tot 191 karakters
        Schema::defaultStringLength(191);
    }
}
