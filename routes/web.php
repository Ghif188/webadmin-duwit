<?php

use Illuminate\Support\Facades\Route;
// Import Controllers
use App\Http\Controllers\AuthOtp\AuthController;
use App\Http\Controllers\Operator\ManagementController;

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

Route::get('/dashboard', function () {
    return view('layout.base');
})->name('dashboard')->middleware('auth');

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('login-send-otp', [AuthController::class, 'sendOtp'])->name('login.sendOtp');
Route::get('login-form-otp/{phone}', [AuthController::class, 'showOtpForm'])->name('login.formOtp');
Route::post('resend-otp', [AuthController::class, 'resendOtp'])->name('login.resendOtp');
Route::post('login-process', [AuthController::class, 'login'])->name('login.process');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('patner', [ManagementController::class, 'getIndexPatner'])->name('patner.list');
Route::get('patner/detail/{id}', [ManagementController::class, 'getDetailPatner'])->name('patner.detail');
Route::put('patner/change-status/{id}', [ManagementController::class, 'postChangeStatusPatner'])->name('patner.changeStatus');

Route::get('account', [ManagementController::class, 'getIndexAccount'])->name('account.list');
Route::get('account/detail/{id}', [ManagementController::class, 'getDetailAccount'])->name('account.detail');
Route::put('account/change-status/{id}', [ManagementController::class, 'postChangeStatusAccount'])->name('account.changeStatus');

Route::get('/otp', function () {
    return view('auth.otp');
})->middleware('auth');
