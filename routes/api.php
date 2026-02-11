<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/**
*   ## Login Routes ##
*/
Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('/login', 'login');
});


Route::middleware('auth:sanctum')->group(function () {

    /**
    *   ## Auth Routes ##
    */
    Route::prefix('auth')->controller(AuthController::class)->group(function () {
        Route::get('/me', 'getAuthMe');
        Route::post('/logout','logout');
    });

    
    //todo: /**
    // *   ## User Routes ##
    // */
    // Route::prefix('user')->controller(UserController::class)->group(function () {
    //     Route::get('/', 'index');
    //     Route::get('/select','getSelect');
    //     Route::get('/{id}','show');
    //     Route::post('/', 'store');
    //     Route::put('/{id}','update');
    //     Route::delete('/{id}','destroy');   
    //     Route::post('/restore/{id}','restore');
    // });
});
