<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LibraryController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::post('refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
    Route::get('me', [AuthController::class, 'me'])->middleware('auth:api');
});

Route::apiResource('library', LibraryController::class)->only(['index', 'show']);
Route::apiResource('books', BookController::class)->only(['index', 'show']);

Route::middleware('auth:api')->group(function () {
    Route::apiResource('library', LibraryController::class)->except(['index', 'show']);
    Route::apiResource('books', BookController::class)->except(['index', 'show']);
    Route::post('cart', [\App\Http\Controllers\CartController::class, 'addBookToCart']);
    Route::get('cart', [\App\Http\Controllers\CartController::class, 'getCart']);
    Route::patch('cart/{id}', [\App\Http\Controllers\CartController::class, 'update']);
    Route::delete('cart/{id}', [\App\Http\Controllers\CartController::class, 'destroy']);
});
