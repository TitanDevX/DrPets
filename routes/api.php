<?php

use App\Http\Controllers\api\AddressController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\BookingController;
use App\Http\Controllers\api\CartController;
use App\Http\Controllers\api\ChatMessageController;
use App\Http\Controllers\api\InvoiceController;
use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\api\PaymentController;
use App\Http\Controllers\api\PetController;
use App\Http\Controllers\api\RatingController;
use App\Http\Controllers\api\ReminderController;
use App\Http\Controllers\api\ServiceController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AddDataMiddleware;
use App\Models\ChatMessage;
use App\Models\Reminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);
Route::get('/service', [ServiceController::class,'index']);

Route::get('/payment/success', [PaymentController::class, 'success'])->name('checkout.success');
Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('checkout.cancel');

Route::get('/rating', [RatingController::class, 'index']);
Route::get('/user/{user}/pfp',[UserController::class,'showPfp']);
Route::middleware(['auth:sanctum', AddDataMiddleware::class])->group(function () {
   
   
    Route::get('/user/pfp',[UserController::class,'indexPfp']);
    Route::post('/user/pfp', [UserController::class,'updatePfp']);
    Route::delete('/user/pfp', [UserController::class,'deletePfp']);

    Route::get('logout',[AuthController::class, 'logout']);
    Route::post('verifyEmail',[AuthController::class, 'verifyEmail']);   
    Route::get('resendOtp',[AuthController::class, 'resendOtp']);

    Route::post('store-fcm-token', [UserController::class,'storeFcmToken']);

    Route::apiResource('pet', PetController::class);
    Route::apiResource('reminder',ReminderController::class);
    Route::apiResource('cart', CartController::class);
    Route::apiResource('address', AddressController::class);
    Route::apiResource('order', OrderController::class);
    Route::apiResource('rating', RatingController::class)->except('index');
    Route::apiResource('chat', ChatController::class)->only(['index','show', 'destroy']);
    Route::apiResource('chat-message', ChatMessageController::class)->only(['index','store']);
   
    Route::get('bookings', [BookingController::class, 'index']);
    Route::post('bookings', [BookingController::class, 'store']);
    Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel']);

    Route::post('/invoices/apply-promo-code', [InvoiceController::class,'applyPromoCode']);
    Route::post('/invoices/{invoice}/pay', [InvoiceController::class, 'pay']);
    Route::post('/invoices', [InvoiceController::class,'store']);
  
    Route::post('/test/accept-booking', [BookingController::class,'testAcceptBooking']);
    Route::get('/test/success-pay', [PaymentController::class,'testSuccessPay']);
    Route::post('/test/testDeliver',[BookingController::class,'testDeliver']);
});
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

