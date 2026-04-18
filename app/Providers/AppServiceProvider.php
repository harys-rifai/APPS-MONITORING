<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

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
        // Register Livewire components
        Livewire::component('server-list', \App\Http\Livewire\ServerList::class);
        Livewire::component('database-list', \App\Http\Livewire\DatabaseList::class);
        Livewire::component('organisation-list', \App\Http\Livewire\OrganisationList::class);
        Livewire::component('branch-list', \App\Http\Livewire\BranchList::class);
        Livewire::component('user-list', \App\Http\Livewire\UserList::class);
        Livewire::component('audit-log-list', \App\Http\Livewire\AuditLogList::class);
        Livewire::component('dashboard', \App\Http\Livewire\Dashboard::class);
        Livewire::component('realtime-database-monitor', \App\Http\Livewire\RealtimeDatabaseMonitor::class);

        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            $appVersion = \Illuminate\Support\Facades\Cache::remember('app_version', 3600, function () {
                return \App\Models\AppVersion::where('is_active', true)->latest()->first()?->version ?? 'v.1.0.0';
            });
            $view->with('appVersion', $appVersion);
        });
    }
}
