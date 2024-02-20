<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserProfileController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/products', [ProductController::class, 'index']);

Route::get('/midtrans', function () {
    return config('midtrans.merchant_id');
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/user', [UserProfileController::class, 'me']);
    Route::put('/user/update', [UserProfileController::class, 'update']);

    Route::get('/cart', [CartController::class, 'getCart']);
    Route::post('/cart/create', [CartController::class, 'addProductToCart']);
    Route::post('/cart/delete', [CartController::class, 'deleteProductFromCart']);
    Route::delete('/cart/{cart}', [CartController::class, 'deleteCart']);
});
