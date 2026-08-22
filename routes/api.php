<?php

use App\Http\Controllers\Api\V1\JobApiController;
use App\Http\Controllers\Api\V1\PlatformApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - AnywhereRoles
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group with throttle protection.
|
*/

Route::prefix('v1')->middleware(['throttle:60,1'])->group(function () {
    // Jobs & Internships
    Route::get('/jobs', [JobApiController::class, 'index'])->name('api.v1.jobs.index');
    Route::get('/jobs/{id}', [JobApiController::class, 'show'])->name('api.v1.jobs.show')->where('id', '[0-9]+');
    Route::get('/internships', [JobApiController::class, 'internships'])->name('api.v1.internships');

    // Companies & Categories
    Route::get('/companies', [PlatformApiController::class, 'companies'])->name('api.v1.companies');
    Route::get('/categories', [PlatformApiController::class, 'categories'])->name('api.v1.categories');

    // Platform Stats & Health
    Route::get('/stats', [PlatformApiController::class, 'stats'])->name('api.v1.stats');
});
