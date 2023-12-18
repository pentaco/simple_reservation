<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoreTimeslotController;
use App\Http\Controllers\CreateTimeslotController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return redirect(route('timeslot.create'));
    })->name('dashboard');
    Route::prefix('timeslot')->name('timeslot.')->group(function() {
        Route::get('/create', CreateTimeslotController::class)->name('create');
        Route::post('/store', StoreTimeslotController::class)->name('store');
    });
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
    Route::get('logout', [AuthenticatedSessionController::class, 'destroy']);

});

