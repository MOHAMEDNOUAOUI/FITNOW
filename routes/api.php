<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authcontroller;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\UserController;

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

Route::post('/auth/register' , [Authcontroller::class , 'register']);
Route::post('/auth/login' , [Authcontroller::class , 'login']);

Route::middleware('auth:sanctum')->group(function(){
    Route::resource('user' , UserController::class);
    Route::resource('progress' , ProgressController::class);
});