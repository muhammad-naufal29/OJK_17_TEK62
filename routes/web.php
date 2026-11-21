<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvestmentController;

Route::get('/', function () {
    return redirect()->route('investments.index');
});

Route::resource('investments', InvestmentController::class)
    ->except(['show']);

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::view('/dashboard', 'dashboard')
    ->name('dashboard');

Route::resource('investments', InvestmentController::class)
    ->except(['show']);