<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\SpinController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/', [HomeController::class, 'store'])->name('payer.create');

Route::middleware(['landing_active:hash'])->group(function () {
    Route::get('/lucky-page/{hash}', [LandingController::class, 'show'])->name('landing.show');
    Route::post('/lucky-page/{hash}', [LandingController::class, 'regenerate'])->name('landing.regenerate');
    Route::delete('/lucky-page/{hash}', [LandingController::class, 'deactivate'])->name('landing.deactivate');

    Route::post('/spin/{hash}', [SpinController::class, 'spin'])->name('spin.create');
    Route::get('/spin/{hash}/history', [SpinController::class, 'latest'])->name('spin.history');
});
