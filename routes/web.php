<<<<<<< HEAD

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvestmentController;

Route::get('/', function () {
    return redirect()->route('investments.index');
});

Route::resource('investments', InvestmentController::class)
    ->except(['show']);
=======
<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
>>>>>>> fc0fbcb10070660af2117c0368f3c04dda0fadaf
