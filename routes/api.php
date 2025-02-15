<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\ClassSheduleController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function (){
Route::resource('users', UserController::class)->middleware('auth:sanctum');
Route::resource('classes', ClasseController::class)->middleware('auth:sanctum');
Route::resource('schedules', ClassSheduleController::class)->middleware('auth:sanctum');
Route::resource('student', StudentController::class)->middleware('auth:sanctum');
Route::resource('payment', PaymentController::class)->middleware('auth:sanctum');
Route::resource('appointment', AppointmentController::class)->middleware('auth:sanctum');
Route::post('logout',[AuthController::class,'logout'])->middleware('auth:sanctum');
Route::post('register',[UserController::class,'store']);
});

Route::post('login', [AuthController::class, 'login']);
