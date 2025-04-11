<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\PetController;
use App\Http\Middleware\AddDataMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);
Route::middleware('auth:sanctum')->middleware(AddDataMiddleware::class)->group(function () {
   
    Route::get('logout',[AuthController::class, 'logout']);
    Route::post('verifyEmail',[AuthController::class, 'verifyEmail']);   
    Route::get('resendOtp',[AuthController::class, 'resendOtp']);

    Route::apiResource('pet', PetController::class);
    
});
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
