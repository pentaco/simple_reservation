<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StoreReservationController;
use App\Http\Controllers\Api\CancelReservationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('api')->name('api.')->group(function() {
    Route::prefix('reservation')->name('reservation.')->group(function() {
        Route::post('store', StoreReservationController::class)->name('store');
        Route::post('cancel', CancelReservationController::class)->name('cancel');
    });
});
