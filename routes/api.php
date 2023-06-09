<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\v1\CategoryController;
use App\Http\Controllers\Api\v1\ProductController;
use App\Http\Controllers\Api\v1\CartController;
use App\Http\Controllers\Api\v1\OrderController;
use App\Http\Controllers\Api\v1\UserController;



Route::prefix('api')->group(function () {

    Route::controller(UserController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});

Route::controller(CartController::class)->group(function () {
    Route::get('/cart', 'addToCart');
    Route::post('/cart/{cartId}', 'updateCartItem');
    Route::post('/cart/{cartId}', 'removeCartItem');

});

Route::middleware(['auth:sanctum'])->group(function () {
   Route::get('/categories', [CategoryController::class, 'index']);
   Route::get('/products', [ProductController::class, 'index']);
});



Route::controller(OrderController::class)->group(function () {
    Route::get('/orders', 'index');
    Route::post('/order', 'placeOrder');
});

});


