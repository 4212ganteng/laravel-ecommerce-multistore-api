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
Route::post('/seller/category', [App\Http\Controllers\Api\CategoryController::class, 'store'])->middleware('auth:sanctum');
// get all categories
Route::get('/seller/categories', [App\Http\Controllers\Api\CategoryController::class, 'index'])->middleware('auth:sanctum');


// product
Route::apiResource('/seller/products', App\Http\Controllers\Api\ProductController::class)->middleware('auth:sanctum');

// update product
Route::post('/seller/products/{id}', [App\Http\Controllers\Api\ProductController::class, 'update'])->middleware('auth:sanctum');


// address
Route::apiResource('/customer/addresses', App\Http\Controllers\Api\AdressController::class)->middleware('auth:sanctum');

// order
Route::post('/customer/orders', [App\Http\Controllers\Api\OrderController::class, 'store'])->middleware('auth:sanctum');


// store
Route::get('/customer/stores', [App\Http\Controllers\Api\StoreController::class, 'index'])->middleware('auth:sanctum');
// product by store
Route::get('/customer/stores/{id}/products', [App\Http\Controllers\Api\StoreController::class, 'productByStore'])->middleware('auth:sanctum');


// update resi
Route::put('/seller/orders/{id}/update-resi', [App\Http\Controllers\Api\OrderController::class, 'updateShippingNumber'])->middleware('auth:sanctum');

// history order buyer
Route::get('/customer/histories', [App\Http\Controllers\Api\OrderController::class, 'history'])->middleware('auth:sanctum');

// history order seller
Route::get('/seller/histories', [App\Http\Controllers\Api\OrderController::class, 'historySeller'])->middleware('auth:sanctum');


// get store live streaming
Route::get('/seller/live-streaming', [App\Http\Controllers\Api\StoreController::class, 'liveStreaming'])->middleware('auth:sanctum');
