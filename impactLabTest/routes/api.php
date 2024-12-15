<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/products', [ProductController::class, 'getAllProducts']);
Route::delete('/users/{id}', [UserController::class, 'removeUser']);
Route::post('/orders', [OrderController::class, 'placeOrder']);

