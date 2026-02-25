<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Traits\HasCrudRoutes;
use Illuminate\Support\Facades\Route;

/**
 *   ## Login Routes ##
 */
Route::prefix('login')->controller(AuthController::class)->group(function () {
    Route::post('/', 'login');
});


Route::middleware('auth:sanctum')->group(function () {

    /**
     *   ## Auth Routes ##
     */
    Route::prefix('auth')->controller(AuthController::class)->group(function () {
        Route::get('/me', 'getAuthMe');
        Route::post('/logout', 'logout');
    });


    /**
     *   ## User Routes ##
     */
    HasCrudRoutes::crudResource('users', UserController::class, [
        'except' => ['store', 'update'],
    ]);

    Route::post('/users', [UserController::class, 'beforeStore'])->middleware('auth:sanctum');
    Route::put('/users/{id}', [UserController::class, 'beforeUpdate'])->middleware('auth:sanctum');
});
