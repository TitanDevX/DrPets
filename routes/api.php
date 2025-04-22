<?php

use App\Http\Controllers\api\AddressController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\BookingController;
use App\Http\Controllers\api\PetController;
use App\Http\Controllers\api\ReminderController;
use App\Http\Controllers\api\ServiceController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AddDataMiddleware;
use App\Models\Reminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);
Route::get('/service', [ServiceController::class,'index']);
Route::middleware(['auth:sanctum', AddDataMiddleware::class])->group(function () {
   
    Route::get('logout',[AuthController::class, 'logout']);
    Route::post('verifyEmail',[AuthController::class, 'verifyEmail']);   
    Route::get('resendOtp',[AuthController::class, 'resendOtp']);

    Route::apiResource('pet', PetController::class);
    Route::apiResource('reminder',ReminderController::class);

    Route::get('bookings', [BookingController::class, 'index']);
    Route::post('store-fcm-token', [UserController::class,'storeFcmToken']);

    Route::post('address', [AddressController::class, 'store']);
    Route::get('address', [AddressController::class, 'index']);
});
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

