<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\TravelPackageController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HotelBookingController as AdminHotelBookingController;
use App\Http\Controllers\Admin\PackageBookingController as AdminPackageBookingController;
use App\Http\Controllers\Admin\TravelPackageController as AdminTravelPackageController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes Publiques
|--------------------------------------------------------------------------
*/

// Page d'accueil
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/search', [HomeController::class, 'search'])->name('search');

// Hôtels
Route::prefix('hotels')->name('hotels.')->group(function () {
    Route::get('/', [HotelController::class, 'index'])->name('index');
    Route::get('/search', [HotelController::class, 'search'])->name('search');
    Route::get('/{id}', [HotelController::class, 'show'])->name('show');
});

// Packages / Circuits
Route::prefix('packages')->name('packages.')->group(function () {
    Route::get('/', [TravelPackageController::class, 'index'])->name('index');
    Route::get('/{slug}', [TravelPackageController::class, 'show'])->name('show');
});

/*
|--------------------------------------------------------------------------
| Routes Authentifiées (Clients)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard client
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Réservations hôtels
    Route::prefix('hotels')->name('hotels.')->group(function () {
        Route::get('/{id}/book', [HotelController::class, 'bookingForm'])->name('booking.form');
        Route::post('/{id}/book', [HotelController::class, 'book'])->name('book');
    });

    // Réservations packages
    Route::prefix('packages')->name('packages.')->group(function () {
        Route::get('/{slug}/book', [TravelPackageController::class, 'bookingForm'])->name('booking.form');
        Route::post('/{slug}/book', [TravelPackageController::class, 'book'])->name('book');
    });

    // Avis
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

/*
|--------------------------------------------------------------------------
| Routes Admin (avec middleware admin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard admin
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Gestion des réservations hôtels
    Route::resource('hotel-bookings', AdminHotelBookingController::class)->except(['create', 'store']);

    // Gestion des réservations packages
    Route::resource('package-bookings', AdminPackageBookingController::class)->except(['create', 'store']);

    // Gestion des packages/circuits
    Route::resource('packages', AdminTravelPackageController::class);

    // Gestion des utilisateurs
    Route::resource('users', AdminUserController::class);

    // Gestion des avis
    Route::resource('reviews', AdminReviewController::class)->only(['index', 'edit', 'update', 'destroy']);
    Route::post('reviews/{review}/publish', [AdminReviewController::class, 'publish'])->name('reviews.publish');
    Route::post('reviews/{review}/respond', [AdminReviewController::class, 'respond'])->name('reviews.respond');
});

require __DIR__.'/auth.php';
