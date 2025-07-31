<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminRequestController;
use App\Http\Controllers\Admin\AdminStaffController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\RestController;
use Illuminate\Http\Request;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::post('login', [AuthenticatedSessionController::class, 'store']);
// ログイン画面（一般ユーザー）
Route::post('/register', [RegisteredUserController::class, 'store']);
// 会員登録画面（一般ユーザー）

Route::get('admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [AdminLoginController::class, 'login']);
Route::post('admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

Route::get('/email/verify', function () {
    if ($user = Auth::user()) {
        $user->sendEmailVerificationNotification();
        return view('auth.verify-email');
    }

    return redirect()->route('login');
})->middleware(['auth'])->name('verification.notice');

Route::post('/email/verification-notification', function (Request $request) {
    $user = Auth::user();

    if ($user && !$user->hasVerifiedEmail()) {
        $user->sendEmailVerificationNotification();
        return back()->with('resent', true);
    }

    return back()->withErrors(['message' => '認証済みのユーザーか、ログイン状態を確認してください。']);
})->middleware('auth')->name('verification.send');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    session()->forget('unauthenticated_user');
    return redirect()->route('attendance.create');
})->name('verification.verify');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/attendance', [AttendanceController::class, 'getCreate'])->name('attendance.create');
    // 勤怠登録画面（一般ユーザー）
    Route::post('/attendance/start', [AttendanceController::class, 'startAttendance'])->name('attendance.start');
    // 勤務開始処理
    Route::post('/attendance/end', [AttendanceController::class, 'endAttendance'])->name('attendance.end');
    // 勤務終了処理

    Route::post('/break/start', [RestController::class, 'startRest'])->name('attendance.break_start');
    // 休憩開始処理
    Route::post('/break/end', [RestController::class, 'endRest'])->name('attendance.break_end');
    // 休憩終了処理

    Route::get('/attendance/list', [AttendanceController::class, 'getList'])->name('attendance.list');
    // 勤怠一覧画面（一般ユーザー）
    Route::get('/attendance/{id}', [RequestController::class, 'getDetail'])->name('attendance.detail');
    // 勤怠詳細画面（一般ユーザー）
    Route::post('/attendance/{id}', [RequestController::class, 'corrective'])->name('attendance.update');
    // 勤怠修正処理

    Route::get('/attendance/request_list', [RequestController::class, 'getRequest'])->name('attendance.request_list');
    // 申請一覧画面（一般ユーザー）
});
// 一般ユーザー用のミドルウェア

Route::prefix('admin')->middleware(['auth:admin'])->group(function () {
    Route::get('/attendances', [AdminStaffController::class, 'getList'])->name('admin.attendance_list');
    // 勤怠一覧画面（管理者）
    Route::get('/staffs', [AdminStaffController::class, 'getStaffList'])->name('admin.staff_list');
    // スタッフ一覧画面（管理者）
    Route::get('/staff/{id}/attendances', [AdminStaffController::class, 'getAttendance'])->name('admin.staff_attendance');
    // スタッフ別勤怠一覧画面表示（管理者）
    Route::get('/attendance/detail/{id}', [AdminStaffController::class, 'getDetail'])->name('admin.attendance_detail');
    // 勤怠詳細画面表示（管理者）
    Route::post('/attendance/detail/{id}/corrective', [AdminStaffController::class, 'corrective']);
    // 勤怠修正処理

    Route::get('/requests', [AdminRequestController::class, 'getRequest'])->name('admin.request_list');
    // 申請一覧画面（管理者）
    Route::get('/request/{id}', [AdminRequestController::class, 'getApprove'])->name('admin.request_approve');
    // 修正申請承認画面（管理者）
    Route::post('/request/{id}', [AdminRequestController::class, 'approve']);
    // 申請承認処理
});
// 管理者用のミドルウェア
