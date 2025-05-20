<?php

use App\Http\Controllers\API\v1\JobListingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PUBLIC JOB LISTING API Routes v1
|--------------------------------------------------------------------------
*/

Route::get('job-listings', JobListingController::class);
