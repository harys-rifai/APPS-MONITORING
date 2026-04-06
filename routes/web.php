<?php

use App\Http\Controllers\ProfileController;
use App\Http\Livewire\AuditLogList;
use App\Http\Livewire\CorporateList;
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
Route::get('/corporates', CorporateList::class)->middleware(['auth', 'verified'])->name('corporates');
Route::get('/users', UserList::class)->middleware(['auth', 'verified'])->name('users');
Route::get('/audit-logs', AuditLogList::class)->middleware(['auth', 'verified'])->name('audit-logs');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';