<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\ReportController;

// Halaman utama diarahkan ke Dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Dashboard
Route::view('/dashboard', 'dashboard')
    ->name('dashboard');

// Import Excel
Route::post('/investments/import-excel',
    [ReportController::class, 'importExcel']
)->name('investments.import');

// Export Excel
Route::get('/investments/export-excel',
    [ReportController::class, 'exportExcel']
)->name('investments.exportExcel');

// CRUD Investasi
Route::resource('investments', InvestmentController::class)
    ->except(['show']);