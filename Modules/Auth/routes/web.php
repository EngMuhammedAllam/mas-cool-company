<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\App\Http\Controllers\Front\AuthController;


// ############################## Auth Routes ################################### //
Route::prefix('auth')->middleware('guest')->group(function () {
    Route::get('/login-form', [AuthController::class, 'loginForm'])->name('loginform');
    Route::post('/dashboard/login', [AuthController::class, 'login'])->name('dashboard.login');
});

Route::prefix('auth')->group(function () {
    Route::get('/dashboard/logout', [AuthController::class, 'logout'])->name('dashboard.logout');
});
