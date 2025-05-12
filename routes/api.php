<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\ClassSheduleController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ScheduleClassesForClasses;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\StudentClassesController;
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
Route::resource('clschedule', ScheduleController::class)->middleware('auth:sanctum');

Route::post('logout',[AuthController::class,'logout'])->middleware('auth:sanctum');
Route::post('student/{id?}',[StudentController::class,'store'])->middleware('auth:sanctum');

Route::post('payment/{id?}',[PaymentController::class,'store'])->middleware('auth:sanctum');
Route::post('class/register',[StudentClassesController::class,'store'])->middleware('auth:sanctum');
Route::post('clasregister',[ScheduleController::class,'store'])->middleware('auth:sanctum');
Route::post('created/schedules/classes',[ScheduleClassesForClasses::class,'store'])->middleware('auth:sanctum');

});
Route::post('v1/register',[UserController::class,'store']);
Route::post('login', [AuthController::class, 'login']);
