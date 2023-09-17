<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PaidLeaveController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('employees', EmployeeController::class);
Route::resource('paidleaves', PaidLeaveController::class);
// Route::get('employees', [EmployeeController::class, 'index']);
Route::post('/employees/proceed/{id}', [EmployeeController::class, 'proceed'])->name('employees.proceed-data');