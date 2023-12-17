<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\WebShowReservationController;
use App\Http\Controllers\Web\WebCreateReservationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', HomeController::class)->name('home');
Route::get('/reserve', WebCreateReservationController::class)->name('reservation.create');
Route::get('reservation', WebShowReservationController::class)->name('reservation.show');





require __DIR__.'/auth.php';
