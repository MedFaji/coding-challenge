<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ProductController;
use \App\Http\Controllers\CategoryController;

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

// Products routes
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{productId}', [ProductController::class, 'show']);
Route::post('/products', [ProductController::class, 'store']);
Route::put('/products/{productId}', [ProductController::class, 'update']);
Route::delete('/products/{productId}', [ProductController::class, 'destroy']);

// Categories routes
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{categoryId}', [CategoryController::class, 'show']);
Route::post('/categories', [CategoryController::class, 'store']);
Route::put('/categories/{categoryId}', [CategoryController::class, 'update']);
Route::delete('/categories/{categoryId}', [CategoryController::class, 'destroy']);

