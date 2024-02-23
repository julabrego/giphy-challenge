<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\FavoriteGifController;
use App\Http\Controllers\GiphyAPIController;
use App\Http\Middleware\LogUserInteraction;

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

Route::post('/register', [AuthController::class, 'register'])->name("register")->middleware(LogUserInteraction::class);

Route::post('/login', [AuthController::class, 'login'])->name('login')->middleware(LogUserInteraction::class);

Route::prefix('gifs')->group(function () {
    Route::get('/search', [GiphyAPIController::class, 'search'])->name('search')->middleware('auth:api')->middleware(LogUserInteraction::class);
    Route::get('/search/{id}', [GiphyAPIController::class, 'searchById'])->name('searchById')->middleware('auth:api')->middleware(LogUserInteraction::class);

    Route::post('/save-favorite-gif', [FavoriteGifController::class, 'save'])->name('saveFavoriteGif')->middleware('auth:api')->middleware(LogUserInteraction::class);
});
