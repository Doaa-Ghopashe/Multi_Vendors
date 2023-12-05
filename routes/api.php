<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\RegisterController;
use \App\Http\Controllers\AuthController;
use \App\Http\Controllers\Controller;
use \Illuminate\Routing\RouteGroup;
use \App\Http\Controllers\AdminController;
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

//Route::group('')

Route::middleware(['api','guest'])->group(function (){
    Route::post('/register',[Controller::class,'register']);

    Route::post('/login',[Controller::class,'login'])->middleware('throttle:5,1');
});



Route::prefix('/admin')->middleware(['guest','auth:admin'])->group(function (){
    Route::post('/register',[AdminController::class,'register']);

    Route::post('/login',[AdminController::class,'login'])->middleware('throttle:5,1');
});

