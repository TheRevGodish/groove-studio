<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

// GET
Route::get('/', function () {
    return redirect()->route('home');
});
Route::get('/home', [HomeController::class, 'showHome'])->name('home');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/reservation', [ReservationController::class, 'showReservation'])->name('reservation');

// POST
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/reservation', [ReservationController::class, 'submitReservation'])->name('reservation.submit');

// middlewares
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});
Route::middleware('auth')->prefix('client')->group(function () {
    Route::get('/dashboard', [ClientController::class, 'index'])->name('client.dashboard');
});

