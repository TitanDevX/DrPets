<?php

use App\Http\Controllers\api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);
Route::middleware('auth:sanctum')->group(function () {
   
    Route::get('logout',[AuthController::class, 'logout']);
    Route::post('verifyEmail',[AuthController::class, 'verifyEmail']);
   
    Route::get('resendOtp',[AuthController::class, 'resendOtp']);

    
});
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
