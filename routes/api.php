<?php

use App\infrastructure\Http\Controllers\Auth\AuthController;
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
Route::get('health', [HealthCheckAction::class, 'execute']);


Route::middleware('log.interactions')->group(function () {
    Route::get('gifs/search', [GetGifsBySpecificationAction::class, 'execute']);
    Route::get('gifs/{id}', [GetGifByIdAction::class, 'execute']);
    Route::post('favorites', [NewFavoriteGifAction::class, 'execute']);
});

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::middleware('auth:api')->get('user', function (Request $request) {
    return $request->user();
});

Route::get('logs', [\App\infrastructure\Http\Controllers\LogController::class, 'showLogs']);
//Route::post('register', [AuthController::class, 'register']);
