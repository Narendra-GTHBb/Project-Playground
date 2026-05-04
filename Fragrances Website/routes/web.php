<?php

use App\Http\Controllers\FragranceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/index.html');
});

Route::get('/collections', [FragranceController::class, 'collections'])->name('collections');
Route::get('/detail', [FragranceController::class, 'featured'])->name('detail');
Route::get('/fragrances/{slug}', [FragranceController::class, 'show'])->name('fragrances.show');
Route::view('/notes', 'pages.notes')->name('notes');
