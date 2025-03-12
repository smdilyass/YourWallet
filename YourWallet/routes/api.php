<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/hello', [AuthController::class,"login"]);

Route::post('/user/register',[UserController::class,'register']);

Route::post('/user/login',[UserController::class,'login']);

Route::middleware('auth:sanctum')->prefix('user')->group(function(){

    Route::post('logout',[UserController::class,'logout'])->name('user.logout');
    
});


