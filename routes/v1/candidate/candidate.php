<?php

use App\Http\Controllers\API\v1\Candidate\JobApplicationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| CANDIDATE JOB APPLICATION API Routes v1
|--------------------------------------------------------------------------
*/

Route::prefix('jobs')->group(function () {
    Route::controller(JobApplicationController::class)->group(function () {

        Route::prefix('{jobListingId}')->group(function () {
            Route::post('apply', 'apply');
        });

        Route::get('my-applications', 'myApplications');
    });
});
