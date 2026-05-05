<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('home');
});

Route::get('/home', [HomeController::class, 'showHome'])->name('home');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/demandes', [AdminController::class, 'demandes'])->name('admin.demandes');
    Route::get('/demandes/{id}', [AdminController::class, 'show'])->name('admin.demandes.show');
    Route::post('/demandes/{id}/valider', [AdminController::class, 'valider'])->name('admin.demandes.valider');
    Route::post('/demandes/{id}/refuser', [AdminController::class, 'refuser'])->name('admin.demandes.refuser');
});

Route::middleware('auth')->prefix('client')->group(function () {
    Route::get('/dashboard', [ClientController::class, 'index'])->name('client.dashboard');
});

