<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('signup',[AuthController::class,'signup']);
Route::post('/login',[AuthController::class,'login']);

Route::middleware('auth:sanctum')->group(function(){
    Route::post('logout',[AuthController::class,'logout']);
    Route::apiResource('products', ProductController::class);
});

// Route::post('logout',[AuthController::class,'logout'])->middleware('auth:sanctum');
// Route::apiResource('products', ProductController::class)->middleware('auth:sanctum');