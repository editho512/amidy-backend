<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use League\CommonMark\Node\Query\OrExpr;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\NotificationController;

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
});
*/



Route::middleware(['guest'])->post('/auth/register', [AuthController::class, 'register']);

Route::prefix('/user')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/', [AuthController::class, 'me']);
    Route::get('/user-type', [UserController::class, 'getUserType']);
    Route::post('/add', [UserController::class, 'store']);
    Route::get('/edit/{user}', [UserController::class, 'edit']);
    Route::post('/update/{user}', [UserController::class, 'update']);
    Route::get('/delete/{user}', [UserController::class, 'delete']);
});

Route::get('/users', [UserController::class, 'index'])->middleware(['auth:sanctum']);

Route::prefix('/setting')->middleware(['auth:sanctum'])->group(function(){
    Route::get('/', [SettingController::class, 'index']);
    Route::post('/add', [SettingController::class, 'store']);

});

Route::prefix('/tag')->middleware(['auth:sanctum'])->group(function(){
    Route::get('/get-type', [TagController::class, 'getType']);
    Route::post('/add', [TagController::class, 'store']);
    Route::get('/edit/{tag}', [TagController::class, 'edit']);
    Route::patch('/update/{tag}', [TagController::class, 'update']);
    Route::delete('/delete/{tag}', [TagController::class, 'delete']);
});
Route::get('/tag/{type}', [TagController::class, 'index']);

Route::prefix('/category')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/get-type', [CategoryController::class, 'getType']);
    Route::post('/add', [CategoryController::class, 'store']);
    Route::get('/edit/{category}', [CategoryController::class, 'edit']);
    Route::patch('/update/{category}', [CategoryController::class, 'update']);
    Route::delete('/delete/{category}', [CategoryController::class, 'delete']);
});
Route::get('/category/{type}', [CategoryController::class, 'index']);

Route::prefix('/product')->middleware(['auth:sanctum'])->group(function(){
    Route::post('/add', [ProductController::class, 'store']);
    Route::post('/update', [ProductController::class, 'update']);
    Route::post('/price/{product}', [ProductController::class, 'updatePrice']);
    Route::post('/stock/{product}', [ProductController::class, 'updateStock']);

});

Route::get('/product/edit/{product}', [ProductController::class, 'edit']);
Route::get('/product', [ProductController::class, 'index']);
Route::get('/product/preview-store', [ProductController::class, 'previewStore']);


Route::prefix('/order')->middleware(['auth:sanctum'])->group(function(){
    Route::get('/', [OrderController::class, 'index']);
    Route::post('/add', [OrderController::class, 'store']);
    Route::get('/edit/{order}', [OrderController::class, 'edit']);
    Route::post('/pay/{order}', [OrderController::class, 'pay']);
    Route::get('/deliver/{order}', [OrderController::class, 'deliver']);

});

Route::post("callback/{provider}", [SocialiteController::class, 'callback'])->name('socialite.callback');

Route::post("/notification/contact-us", [NotificationController::class, 'contactUs']);






