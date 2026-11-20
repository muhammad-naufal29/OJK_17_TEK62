
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvestmentController;

Route::get('/', function () {
    return redirect()->route('investments.index');
});

Route::resource('investments', InvestmentController::class)
    ->except(['show']);
