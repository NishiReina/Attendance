<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AttendanceController;

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

Route::prefix('admin')->group(function () {
    Route::get('login', [LoginController::class, 'create'])->name('admin.login');
    Route::post('login', [LoginController::class, 'store']);

    Route::middleware('auth:admin')->group(function () {
        Route::get('home', [AdminController::class, 'index']);
    });
});

Route::middleware(['auth:web', 'verified'])->group(function () {
    Route::get('home', [AdminController::class, 'index']);
    Route::get('/attendance', [AttendanceController::class, 'top']);
    Route::post('/attendance/start', [AttendanceController::class, 'start']);
    Route::post('/attendance/end/{attendance}', [AttendanceController::class, 'end']);
    Route::post('/attendance/rest_start/{id}', [AttendanceController::class, 'startRest']);
    Route::post('/attendance/rest_end/{rest}', [AttendanceController::class, 'endRest']);
    Route::get('/attendance/list',[AttendanceController::class, 'getAttendancesList']);
    Route::get('/attendance/{attendance}',[AttendanceController::class, 'getAttendance'])->name('attendance.detail');
    Route::post('/attendance/{attendance}',[AttendanceController::class, 'stampCorrection']);
    Route::get('/attendance/request/{attendance_correct_request}',[AttendanceController::class, 'getStampCorrectRequest'])->name('attendance.request');
});
