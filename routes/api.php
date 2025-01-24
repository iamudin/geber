<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OtpController;
use App\Http\Controllers\Auth\ApiBaseController;
Route::match(['post','get','delete'],'login',[ApiBaseController::class,'login']);
Route::match(['post','get','delete'],'register',[ApiBaseController::class,'register']);
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


