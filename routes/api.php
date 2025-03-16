<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;

Route::apiResource('order-items', OrderItemController::class);

Route::apiResource('orders', OrderController::class);

Route::apiResource('carts', CartController::class);

Route::apiResource('products', ProductController::class);

Route::apiResource('users', UserController::class);
