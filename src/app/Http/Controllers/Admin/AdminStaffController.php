<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use Carbon\Carbon;

class AdminStaffController extends Controller
{
    public function getStaffList()
    {
        $users = User::all();
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
            ->where('date', $targetDate) // 例：2023-06-01
            ->get();
        return view('admin.attendance_list', compact('attendances', 'targetDate'));
    }

    public function getDetail($id)
    {
        $attendance = Attendance::with(['users', 'rests'])
            ->findOrFail($id);

        return view('admin.attendance_detail', compact('attendance'));
    }

    public function corrective(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->start_time = $request->start_time;
        $attendance->end_time = $request->end_time;
        $attendance->note = $request->note;
        $attendance->save();

        foreach ($attendance->rests as $i => $rest) {
            if (isset($request->break_start[$i]) && isset($request->break_end[$i])) {
                $rest->start_time = $request->break_start[$i];
                $rest->end_time = $request->break_end[$i];
                $rest->save();
            }
        }

        return redirect()->route('admin.attendance_detail', $id)->with('message', '修正しました');
    }
}
