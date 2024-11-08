<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\SpinController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/', [HomeController::class, 'store']);

Route::get('/lucky-page/{hash}', [LandingController::class, 'show']);
Route::post('/lucky-page/{hash}', [LandingController::class, 'regenerate']);
Route::delete('/lucky-page/{hash}', [LandingController::class, 'deactivate']);

Route::post('/spin/{hash}', [SpinController::class, 'spin'])->name('spin.create');
Route::get('/spin/{hash}/history', [SpinController::class, 'latest'])->name('spin.history');
