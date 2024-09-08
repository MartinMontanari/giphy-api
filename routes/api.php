<?php

use App\infrastructure\Http\Controllers\Auth\AuthController;
use App\infrastructure\Http\Controllers\gifs\GetGifsBySpecificationAction;
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
Route::get('/', function () {
    return view('welcome');
});

//Route::post('register', [AuthController::class, 'register']);
Route::get('gifs/search', [GetGifsBySpecificationAction::class, 'execute']);
Route::get('logs', [\App\infrastructure\Http\Controllers\LogController::class, 'showLogs']);
Route::middleware('auth:api')->group(function () {
//    Route::get('user', 'AuthController@user');
//    // Other authenticated routes...
});
