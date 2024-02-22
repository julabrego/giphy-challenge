<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\GiphyAPIController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [AuthController::class, 'register'])->name("register");

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::prefix('gifs')->group(function () {
    Route::get('/search', [GiphyAPIController::class, 'search'])->name('search');
});
