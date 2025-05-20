<?php

use App\Http\Controllers\API\v1\Candidate\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| CANDIDATE AUTH API Routes v1
|--------------------------------------------------------------------------
*/

Route::prefix('auth')->group(function () {
    Route::controller(AuthController::class)->group(function () {

        Route::post('register', 'register');
        Route::post('login', 'login');

        Route::post('logout', 'logout')->middleware('auth:api-candidate');
    });
});
