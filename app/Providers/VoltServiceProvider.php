<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Volt\Volt;

class VoltServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Only mount Volt file-based components from resources/views
        // Class-based components are registered in AppServiceProvider
        Volt::mount([
            resource_path('views/pages'),
        ]);
    }
}
