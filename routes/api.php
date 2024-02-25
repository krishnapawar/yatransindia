<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{UserApiController,AuthController};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function() {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});

Route::middleware('auth:sanctum')->group( function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::controller(UserApiController::class)->group(function(){
        Route::get('/users-list', 'index');
        Route::get('/user/{id}', 'show');
        Route::post('/store-user-info', 'storeUserInfo'); 
        Route::put('/update-user-info/{id}', 'updateUserInfo'); 
        Route::delete('/user/{id}', 'destroy');  
    });
});
