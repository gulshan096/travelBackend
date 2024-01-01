<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Administrator;
use App\Http\Controllers\PaymentController;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('register',[Administrator::class,'register']);
Route::post('login',[Administrator::class,'login']);
Route::post('createOrder',[PaymentController::class,'createOrder']);
Route::post('paymentCallback',[PaymentController::class,'paymentCallback']);
