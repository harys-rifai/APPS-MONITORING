<?php

use App\Http\Controllers\Api\MetricController;
use App\Http\Controllers\Api\HealthController;
use Illuminate\Support\Facades\Route;

Route::post('/metrics', [MetricController::class, 'store']);
Route::post('/metrics/sign', [MetricController::class, 'generateSignedPayload']);
Route::get('/health', [HealthController::class, 'index']);