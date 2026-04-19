<?php

use App\Http\Controllers\ProfileController;
use App\Http\Livewire\AuditLogList;
use App\Http\Livewire\BranchList;
use App\Http\Livewire\OrganisationList;
use App\Http\Livewire\DatabaseList;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\RealtimeDatabaseMonitor;
use App\Http\Livewire\ServerList;
use App\Http\Livewire\UserList;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', Dashboard::class)->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/servers', ServerList::class)->middleware(['auth', 'verified'])->name('servers');
Route::get('/databases', DatabaseList::class)->middleware(['auth', 'verified'])->name('databases');
Route::get('/database/{id}/monitor', RealtimeDatabaseMonitor::class)->middleware(['auth', 'verified'])->name('database.monitor');
Route::get('/organisations', OrganisationList::class)->middleware(['auth', 'verified'])->name('organisations');
Route::get('/branches', BranchList::class)->middleware(['auth', 'verified'])->name('branches');
Route::get('/users', UserList::class)->middleware(['auth', 'verified'])->name('users');
Route::get('/audit-logs', AuditLogList::class)->middleware(['auth', 'verified'])->name('audit-logs');
Route::get('/language/{locale}', [\App\Http\Controllers\LanguageController::class, 'switch'])->name('language.switch');

Route::get('/__debug/run-time-config', function () {
    return response()->json([
        'env_app_key' => env('APP_KEY'),
        'config_app_key' => config('app.key'),
        'config_app_debug' => config('app.debug'),
        'env_db_connection' => env('DB_CONNECTION'),
        'config_db_connection' => config('database.default'),
        'config_db_host' => config('database.connections.' . config('database.default') . '.host'),
        'config_db_port' => config('database.connections.' . config('database.default') . '.port'),
        'config_db_database' => config('database.connections.' . config('database.default') . '.database'),
        'env_exists' => file_exists(base_path('.env')),
        'environment_path' => app()->environmentPath(),
        'environment_file' => app()->environmentFile(),
    ]);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
