<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use App\Models\EditRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminStaffController extends Controller
{
    public function getStaffList()
    {
        $users = User::where('role', 'user')->get(); // 管理者を除外
        return view('admin.staff_list', compact('users'));
    }

    public function getAttendance($id, Request $request)
    {
        $user = User::findOrFail($id);

        $targetMonth = $request->input('month', Carbon::now()->format('Y-m'));

        $startOfMonth = Carbon::parse($targetMonth)->startOfMonth();
        $endOfMonth = Carbon::parse($targetMonth)->endOfMonth();

        $attendances = Attendance::with('rests')
            ->where('user_id', $id)
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->orderBy('date', 'asc')
            ->get();

        return view('admin.staff_attendance', compact('user', 'attendances', 'targetMonth'));
    }

    public function getList(Request $request)
    {
        $targetDate = $request->input('date', Carbon::now()->toDateString());

        $attendances = Attendance::with(['user', 'rests'])
            ->where('date', $targetDate)
            ->get();

        return view('admin.attendance_list', compact('attendances', 'targetDate'));
    }

    public function getDetail($id)
    {
        $attendance = Attendance::with(['user', 'rests'])
            ->findOrFail($id);

        return view('admin.attendance_detail', compact('attendance'));
    }

    public function corrective(EditRequestForm $request, $id)
    {
        $attendance = Attendance::findOrFail($id);

        EditRequest::create([
            'attendance_id' => $attendance->id,
            'user_id' => Auth::id(),
            'new_start_time' => $request->input('new_start_time'),
            'new_end_time' => $request->input('new_end_time'),
            'new_rests' => $request->input('new_rests'),
            'note' => $request->input('note'),
            'status' => 'pending',
        ]);

        return redirect()->route('attendance.index')->with('success', '修正申請を送信しました。');
    }
}
