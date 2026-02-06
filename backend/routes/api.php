<?php

use App\Http\Controllers\StopController;
use App\Http\Controllers\TransportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('transports', TransportController::class)->only(['index', 'show']);

Route::apiResource('stops', StopController::class)->only(['index', 'show']);
