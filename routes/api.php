<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\InvestmentApiController;
use App\Http\Controllers\Api\DashboardApiController;
use App\Http\Controllers\Api\ReportApiController;

/*
|--------------------------------------------------------------------------
| API Investasi Reksa Dana
|--------------------------------------------------------------------------
| Prefix URL: /api
| Response : JSON
| Auth     : Laravel Sanctum (Bearer Token)
|
| Endpoint yang bersifat publik: /api/ping, /api/auth/register, /api/auth/login
| Endpoint lainnya wajib menyertakan header:
|     Authorization: Bearer <token>
|--------------------------------------------------------------------------
*/

// Health check (publik)
Route::get('/ping', function () {
    return response()->json([
        'success' => true,
        'message' => 'API Investasi Reksa Dana berjalan',
    ]);
});

// ============================ AUTENTIKASI ============================
Route::post('/auth/register', [AuthApiController::class, 'register']);
Route::post('/auth/login', [AuthApiController::class, 'login']);

// ================== ENDPOINT YANG DILINDUNGI TOKEN ==================
Route::middleware('auth:sanctum')->group(function () {

    // Autentikasi
    Route::get('/auth/me', [AuthApiController::class, 'me']);
    Route::post('/auth/logout', [AuthApiController::class, 'logout']);

    // Statistik dashboard
    Route::get('/dashboard/stats', [DashboardApiController::class, 'stats']);

    // Import / Export Excel (didaftarkan sebelum route {id})
    Route::post('/investments/import-excel', [ReportApiController::class, 'importExcel']);
    Route::get('/investments/export-excel', [ReportApiController::class, 'exportExcel']);
    Route::get('/investments/template-excel', [ReportApiController::class, 'downloadTemplate']);

    // CRUD Investasi
    Route::get('/investments', [InvestmentApiController::class, 'index']);
    Route::post('/investments', [InvestmentApiController::class, 'store']);
    Route::get('/investments/{id}', [InvestmentApiController::class, 'show']);
    Route::put('/investments/{id}', [InvestmentApiController::class, 'update']);
    Route::patch('/investments/{id}', [InvestmentApiController::class, 'update']);
    Route::delete('/investments/{id}', [InvestmentApiController::class, 'destroy']);
});
