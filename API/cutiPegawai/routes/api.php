<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PaidLeaveController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
// use App\Http\Controllers\Auth\AuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/employees/store', [EmployeeController::class, 'store']);
Route::get('/employees', [EmployeeController::class, 'index']);
Route::get('/employees/{id}', [EmployeeController::class, 'show']);
Route::patch('/employees/update/{id}', [EmployeeController::class, 'update']);
Route::delete('/employees/delete/{id}', [EmployeeController::class, 'destroy']);
Route::post('/employees/proceed/{id}', [EmployeeController::class, 'proceed']);

Route::get('/paidleaves', [PaidLeaveController::class, 'index']);
Route::get('/paidleaves/{id}', [PaidLeaveController::class, 'show']);
Route::patch('/paidleaves/update/{id}', [PaidLeaveController::class, 'update']);
Route::get('/paidleaves/delete/{id}', [PaidLeaveController::class, 'destroy']);
Route::post('/paidleaves/proceed/{id}', [PaidLeaveController::class, 'proceed']);


Route::post('/register',[AuthController::class, 'register']);
Route::post('/login',[AuthController::class, 'login']);