<?php

use App\Http\Controllers\ProfileController;
use App\Http\Livewire\DatabaseList;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\ServerList;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', Dashboard::class)->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/servers', ServerList::class)->middleware(['auth', 'verified'])->name('servers');
Route::get('/databases', DatabaseList::class)->middleware(['auth', 'verified'])->name('databases');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';