<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{UserController,HomeController};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::group(['prefix'=>'dashboard','middleware'=>'auth'],function(){
    Route::resource('/users',UserController::class);
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
});
