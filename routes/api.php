<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API VERSION 1 ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('v1')->group(function () {
    Route::prefix('company')->group(function () {
        require __DIR__ . '/v1/company/auth.php';
    });

    Route::prefix('candidate')->group(function () {
        require __DIR__ . '/v1/candidate/auth.php';
    });
});
