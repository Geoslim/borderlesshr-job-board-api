<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API VERSION 1 ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('v1')->group(function () {
    Route::prefix('company')->group(function () {
        require __DIR__ . '/v1/company/auth.php';

        Route::middleware('auth:company')->group(function () {
            require __DIR__ . '/v1/company/company.php';
            require __DIR__ . '/v1/company/job-listing.php';
        });
    });

    Route::prefix('candidate')->group(function () {
        require __DIR__ . '/v1/candidate/auth.php';

        Route::middleware('auth:candidate')->group(function () {
            require __DIR__ . '/v1/candidate/candidate.php';
        });
    });

    Route::prefix('public')->group(function () {
        require __DIR__ . '/v1/job-listing.php';
    });
});
