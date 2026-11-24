<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\InvestmentApiController;
use App\Http\Controllers\Api\ReportApiController;

// ============================================================
// API ENDPOINT - INVESTASI REKSA DANA
// Prefix URL: /api/investments
// Tidak memerlukan CSRF token (middleware 'api')
// Response berupa JSON
// ============================================================

// Health check API
Route::get('/ping', function () {
    return response()->json([
        'success' => true,
        'message' => 'API Investasi Reksa Dana berjalan',
    ]);
});

// CRUD Investasi
Route::get('/investments', [InvestmentApiController::class, 'index']);
Route::get('/investments/{id}', [InvestmentApiController::class, 'show']);
Route::post('/investments', [InvestmentApiController::class, 'store']);
Route::put('/investments/{id}', [InvestmentApiController::class, 'update']);
Route::patch('/investments/{id}', [InvestmentApiController::class, 'update']);
Route::delete('/investments/{id}', [InvestmentApiController::class, 'destroy']);

// Import / Export Excel
Route::post('/investments/import-excel', [ReportApiController::class, 'importExcel']);
Route::get('/investments/export-excel', [ReportApiController::class, 'exportExcel']);
Route::get('/investments/template-excel', [ReportApiController::class, 'downloadTemplate']);
