<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HotelController as ApiHotelController;
use App\Http\Controllers\Api\TravelPackageController as ApiTravelPackageController;
use App\Http\Controllers\Api\BookingController as ApiBookingController;

/*
|--------------------------------------------------------------------------
| API Routes pour Application Mobile
|--------------------------------------------------------------------------
*/

// Routes publiques
Route::prefix('v1')->group(function () {
    // Authentication
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    // Hotels (public)
    Route::get('/hotels', [ApiHotelController::class, 'index']);
    Route::get('/hotels/{id}', [ApiHotelController::class, 'show']);
    Route::post('/hotels/search', [ApiHotelController::class, 'search']);

    // Packages (public)
    Route::get('/packages', [ApiTravelPackageController::class, 'index']);
    Route::get('/packages/featured', [ApiTravelPackageController::class, 'featured']);
    Route::get('/packages/{slug}', [ApiTravelPackageController::class, 'show']);
});

// Routes authentifiées
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    // User
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Bookings
    Route::get('/bookings', [ApiBookingController::class, 'index']);
    Route::get('/bookings/{type}/{id}', [ApiBookingController::class, 'show']);
    Route::post('/bookings/{type}/{id}/cancel', [ApiBookingController::class, 'cancel']);
});
