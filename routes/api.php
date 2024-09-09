<?php

use App\infrastructure\Http\Controllers\Auth\OauthLoginAction;
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

    Route::post('login', [OauthLoginAction::class, 'execute']);
    Route::post('register', [RegisterOauthClientAction::class, 'execute']);


    Route::get('gifs/search', [GetGifsBySpecificationAction::class, 'execute']);
    Route::get('gifs/{id}', [GetGifByIdAction::class, 'execute']);
    Route::post('favorites', [NewFavoriteGifAction::class, 'execute']);
//
//    Route::middleware('auth:api')->group(function () {
//    });
});



Route::get('logs', [\App\infrastructure\Http\Controllers\LogController::class, 'showLogs']);
//Route::post('register', [AuthController::class, 'register']);
