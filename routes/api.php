<?php

use App\infrastructure\Http\Controllers\Auth\LoginOauthClientAction;
use App\infrastructure\Http\Controllers\Auth\RegisterOauthClientAction;
use App\infrastructure\Http\Controllers\favorites\NewFavoriteGifAction;
use App\infrastructure\Http\Controllers\Gifs\GetGifByIdAction;
use App\infrastructure\Http\Controllers\Gifs\GetGifsBySpecificationAction;
use App\infrastructure\Http\Controllers\Health\HealthCheckAction;
use Illuminate\Support\Facades\Route;

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


Route::middleware('log.interactions')->group(function () {
    Route::get('health', [HealthCheckAction::class, 'execute']);

    Route::post('login', [LoginOauthClientAction::class, 'execute'])->name('login');
    Route::post('register', [RegisterOauthClientAction::class, 'execute'])->name('register');

    Route::middleware('auth:api')->group(function () {
        Route::get('gifs/search', [GetGifsBySpecificationAction::class, 'execute'])->name('gif/search');
        Route::get('gifs/{id}', [GetGifByIdAction::class, 'execute'])->name('gif/id');
        Route::post('favorites', [NewFavoriteGifAction::class, 'execute'])->name('favorites');
    });
});


Route::get('logs', [\App\infrastructure\Http\Controllers\LogController::class, 'showLogs']);
//Route::post('register', [AuthController::class, 'register']);
