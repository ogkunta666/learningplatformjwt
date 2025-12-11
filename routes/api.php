<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\JwtAuthController;
use App\Http\Controllers\UserController;

Route::get('/ping', function () {return response()->json(['message' => 'API works!'], 200);});



Route::group([
    'middleware' => 'api',
    'prefix' => 'auth' 
], function ($router) {
    Route::post('register', [JwtAuthController::class, 'register']);
    Route::post('login', [JwtAuthController::class, 'login']);


    Route::post('logout', [JwtAuthController::class, 'logout'])->middleware('auth:api');
    Route::post('refresh', [JwtAuthController::class, 'refresh'])->middleware('auth:api');
});



Route::group([
    'middleware' => ['api', 'auth:api'], 
    'prefix' => 'users' 
], function ($router) {
    
   
    Route::get('/me', [UserController::class, 'me']); 
    Route::put('/me', [UserController::class, 'updateMe']);


    Route::get('/', [UserController::class, 'index']); 
    Route::get('/{id}', [UserController::class, 'show']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
});

