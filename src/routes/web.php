<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\StampCorrectionController;

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

Route::prefix('admin')->group(function () {
    Route::get('login', [LoginController::class, 'create'])->name('admin.login');
    Route::post('login', [LoginController::class, 'store']);

    Route::middleware('auth:admin')->group(function () {
        Route::get('/staff/list', [AdminController::class, 'getStaffList']);
        Route::get('/attendance/list', [AdminController::class, 'getDayAttendance']);
        Route::get('/attendance/staff/{id}', [AdminController::class, 'getAttendancesList']);
        Route::post('/attendance/staff/{staff_id}/{ymd}', [AdminController::class, 'putCsvAttendancesList']);
        // Route::get('/stamp_correction_request/list',[StampCorrectionController::class, 'getRequestList'])->name('attendance.request_list');
        Route::post('/stamp_correction_request/approve/{attendance_correct_request}',[StampCorrectionController::class, 'approveRequest'])->name('attendance.approve');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/attendance', [AttendanceController::class, 'top']);
    Route::post('/attendance/start', [AttendanceController::class, 'start']);
    Route::post('/attendance/end/{attendance}', [AttendanceController::class, 'end']);
    Route::post('/attendance/rest_start/{id}', [AttendanceController::class, 'startRest']);
    Route::post('/attendance/rest_end/{rest}', [AttendanceController::class, 'endRest']);
   
});

Route::middleware(['auth:web,admin'])->group(function () {
    Route::post('logout', [LoginController::class, 'destroy']);

    Route::get('/attendance/list',[AttendanceController::class, 'getAttendancesList']);
    Route::get('/attendance/{attendance}',[AttendanceController::class, 'getAttendance'])->name('attendance.detail');
    Route::get('/stamp_correction_request/list',[StampCorrectionController::class, 'getRequestList'])->name('attendance.request_list');
    Route::get('/stamp_correction_request/detail/{attendance_correct_request}',[StampCorrectionController::class, 'getRequest'])->name('attendance.request');
    Route::post('/attendance/{attendance}',[StampCorrectionController::class, 'stampCorrection']);
});

