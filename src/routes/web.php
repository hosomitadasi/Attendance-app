<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\RestController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('login', [AuthenticatedSessionController::class, 'store']);
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::middleware(['auth'])->group(function () {
    Route::get('/attendance', [AttendanceController::class, 'create'])->name('attendance.create');
    // 勤怠登録画面表示
    Route::get('/attendance/start', [AttendanceController::class, 'startAttendance']);
    // 勤務開始処理
    Route::get('/attendance/end', [AttendanceController::class, 'endAttendance']);
    // 勤務終了処理

    Route::get('/break/start', [RestController::class, 'startRest']);
    // 休憩開始処理
    Route::get('/break/end', [RestController::class, 'endRest']);
    // 休憩終了処理

    Route::get('/attendance/list', [ListController::class, 'getList']);
    // 勤怠一覧画面表示
    Route::get('/attendance/{id}', [ListController::class, 'detail']);
    // 勤怠詳細画面表示
});
// 一般ユーザー用のミドルウェア

Route::prefix('admin')->middleware(['auth:admin'])->group(function () {
    Route::get('/attendance/list', [AdminAttendanceController::class, 'index'])->name('admin.attendance.list');
    Route::get('/attendance/{id}', [AdminAttendanceController::class, 'show'])->name('admin.attendance.detail');

    Route::get('/staff/list', [AdminStaffController::class, 'index'])->name('admin.staff.list');
    Route::get('/staff/{id}/attendance', [AdminAttendanceController::class, 'staffAttendance'])->name('admin.staff.attendance');

    Route::get('/attendance/requests', [AdminRequestController::class, 'index'])->name('admin.requests.list');
    Route::get('/attendance/requests/{id}/approve', [AdminRequestController::class, 'approve'])->name('admin.requests.approve');
    Route::post('/attendance/requests/{id}/approve', [AdminRequestController::class, 'doApprove'])->name('admin.requests.do_approve');
});
// 管理者用のミドルウェア
