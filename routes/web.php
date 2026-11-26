<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;

// ===== AUTENTIKASI =====
Route::get('/login', [AuthController::class, 'showLoginForm'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->middleware('guest');

Route::get('/register', [AuthController::class, 'showRegisterForm'])
    ->middleware('guest')
    ->name('register');

Route::post('/register', [AuthController::class, 'register'])
    ->middleware('guest');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Halaman utama diarahkan ke Dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// ===== RUTE TERPROTEKSI (wajib login) =====
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Import Excel
    Route::post('/investments/import-excel',
        [ReportController::class, 'importExcel']
    )->name('investments.import');

    // Export Excel
    Route::get('/investments/export-excel',
        [ReportController::class, 'exportExcel']
    )->name('investments.exportExcel');

    // Template Excel
    Route::get('/investments/template',
        [InvestmentController::class, 'template']
    )->name('investments.template');

    // CRUD Investasi
    Route::resource('investments', InvestmentController::class)
        ->except(['show']);
});
