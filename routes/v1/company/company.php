<?php

use App\Http\Controllers\API\v1\Company\CompanyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| COMPANY API Routes v1
|--------------------------------------------------------------------------
*/

Route::get('dashboard', CompanyController::class);
