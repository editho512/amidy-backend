<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get('/user', [AuthController::class, 'me'])->middleware(['auth:sanctum']);

/**
 *  Routes pour collaborateur
 */

Route::prefix('collaborator')->middleware(['auth:sanctum'])->group(function () {
    Route::post('/add', [UserController::class, 'store']);
});


