<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\RoleController;
use Illuminate\Support\Facades\Route;

// Route group untuk API v1
Route::prefix('v1')->group(function () {
    // Route group untuk authentication
    Route::controller(AuthController::class)->group(function () {
        Route::post('register', 'register')->name('register');
        Route::post('login', 'login')->name('login');

        // Route yang membutuhkan authentication
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/logout', 'logout')->name('logout');
        });
    });

    Route::apiResource('roles', RoleController::class);
});
