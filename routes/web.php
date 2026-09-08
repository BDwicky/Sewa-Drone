<?php

use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\DroneController;
use App\Http\Controllers\CatalogController;
use Illuminate\Support\Facades\Route;

// Public catalog
Route::get('/', [CatalogController::class, 'index'])->name('home');
Route::get('/drones/{drone}', [CatalogController::class, 'show'])->name('drones.show');

// Booking flow (added in phase 3)
Route::get('/drones/{drone}/booking', [App\Http\Controllers\BookingController::class, 'create'])->name('bookings.create');
Route::post('/drones/{drone}/booking', [App\Http\Controllers\BookingController::class, 'store'])->name('bookings.store');
Route::get('/bookings/{code}', [App\Http\Controllers\BookingController::class, 'show'])->name('bookings.show');
Route::get('/api/drones/{drone}/availability', [App\Http\Controllers\BookingController::class, 'availability'])->name('drones.availability');

// Payment (Midtrans Snap, phase 3.5)
Route::get('/pay/{booking:code}', [App\Http\Controllers\SnapController::class, 'create'])->name('pay.create');
Route::get('/pay/finish', [App\Http\Controllers\SnapController::class, 'finish'])->name('pay.finish');
Route::post('/api/midtrans/webhook', [App\Http\Controllers\SnapController::class, 'webhook'])->name('midtrans.webhook');

// Invoice & tracking (phase 3.6)
Route::get('/invoice/{number}', [App\Http\Controllers\InvoiceController::class, 'show'])->where('number', '.*')->name('invoice.show');
Route::get('/track/{code}', [App\Http\Controllers\TrackController::class, 'show'])->name('track.show');

// Static pages
Route::view('/kebijakan', 'pages.kebijakan')->name('pages.kebijakan');
Route::view('/faq', 'pages.faq')->name('pages.faq');

// Admin panel (phase 4)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn () => redirect()->route('admin.bookings.index'));
    Route::resource('drones', DroneController::class);
    Route::get('bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('bookings/{booking}', [AdminBookingController::class, 'show'])->name('bookings.show');
    Route::patch('bookings/{booking}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.status');
});

require __DIR__.'/auth.php';
