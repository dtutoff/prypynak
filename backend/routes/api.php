<?php

use App\Http\Controllers\Api\v1\FavoriteController;
use App\Http\Controllers\Api\v1\StopController;
use App\Http\Controllers\Api\v1\TransportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', fn(Request $request) => $request->user());
        Route::post('/stops/{stop}/favorite',
            fn(Request $request) => [FavoriteController::class => 'toggle']);
    });

    Route::apiResource('transports', TransportController::class)->only(['index', 'show']);

    Route::apiResource('stops', StopController::class)->only(['index', 'show']);
});

