<?php

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



// login
Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);
// logout
Route::post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout'])->middleware('auth:sanctum');


// register seller
Route::post('/seller/register', [App\Http\Controllers\Api\AuthController::class, 'registerSeller']);
// register customer
Route::post('/customer/register', [App\Http\Controllers\Api\AuthController::class, 'registerUser']);


// store category
Route::post('seller/category', [App\Http\Controllers\Api\CategoryController::class, 'store'])->middleware('auth:sanctum');
// get all categories
Route::get('seller/category', [App\Http\Controllers\Api\CategoryController::class, 'index'])->middleware('auth:sanctum');

