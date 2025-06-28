<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminRequestController;
use App\Http\Controllers\Admin\AdminStaffController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\RestController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('login', [AuthenticatedSessionController::class, 'store']);
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::middleware(['auth'])->group(function () {
    Route::get('/attendance/create', [AttendanceController::class, 'getCreate'])->name('attendance.create');
    // 勤怠登録画面表示
    Route::get('/attendance/start', [AttendanceController::class, 'startAttendance']);
    // 勤務開始処理
    Route::get('/attendance/end', [AttendanceController::class, 'endAttendance']);
    // 勤務終了処理

    Route::get('/break/start', [RestController::class, 'startRest']);
    // 休憩開始処理
    Route::get('/break/end', [RestController::class, 'endRest']);
    // 休憩終了処理

    Route::get('/attendance/list', [AttendanceController::class, 'getList'])->name('attendance.list');
    // 勤怠一覧画面表示
    Route::get('/attendance/{id}', [RequestController::class, 'getDetail'])->name('attendance.detail');
    // 勤怠詳細画面表示
    Route::post('/attendance/{id}', [RequestController::class, 'corrective']);
    // 勤怠修正処理
    Route::get('/attendance/{id}', [RequestController::class, 'getRequest'])->name('attendance.request_list');
    // 申請一覧画面表示
});
// 一般ユーザー用のミドルウェア

Route::prefix('admin')->middleware(['auth:admin'])->group(function () {
    Route::get('/staffs', [AdminStaffController::class, 'getStaffList']);
    Route::get('/staff/{id}/attendances', [AdminStaffController::class, 'getAttendance']);
    Route::get('/attendances', [AdminStaffController::class, 'getList']);
    Route::get('/attendance/detail/{id}', [AdminStaffController::class, 'getDetail']);
    Route::post('/attendance/detail/{id}/corrective', [AdminStaffController::class, 'corrective']);

    Route::get('/requests', [AdminRequestController::class, 'getRequest']);
    Route::get('/request/{id}', [AdminRequestController::class, 'getApprove']);
    Route::post('/request/{id}', [AdminRequestController::class, 'approve']);
});
// 管理者用のミドルウェア
