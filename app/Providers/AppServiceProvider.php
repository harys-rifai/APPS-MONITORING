<?php

namespace App\Providers;

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
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            $latestVersion = \App\Models\AppVersion::where('is_active', true)->latest()->first();
            $view->with('appVersion', $latestVersion ? $latestVersion->version : 'v.1.0.0');
        });
    }
}
