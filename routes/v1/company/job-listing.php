<?php

use App\Http\Controllers\API\v1\Company\JobListingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| COMPANY AUTH API Routes v1
|--------------------------------------------------------------------------
*/

Route::prefix('job-listings')->group(function () {
    Route::controller(JobListingController::class)->group(function () {
        Route::get('', 'index');
        Route::post('create', 'create');

        Route::prefix('{jobListingId}')->group(function () {
            Route::get('view', 'view');
            Route::put('update', 'update');
            Route::delete('delete', 'delete');
        });
    });
});
