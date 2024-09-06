<?php

use App\infrastructure\Http\Controllers\Auth\AuthController;
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

Route::post('register', [AuthController::class, 'register']);
Route::middleware('auth:api')->group(function () {
//    Route::get('user', 'AuthController@user');
//    // Other authenticated routes...
});
