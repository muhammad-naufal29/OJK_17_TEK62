<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;

// Halaman utama diarahkan ke Dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

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

// CRUD Investasi
Route::resource('investments', InvestmentController::class)
    ->except(['show']);

Route::get('/investments/template', [InvestmentController::class, 'template'])->name('investments.template');