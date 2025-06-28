<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function getCreate()
    {
        $attendance = Attendance::getAttendance();
        $status = 'before_work';

        if (!empty($attendance)) {
            if (!empty($attendance->end_time)) {
                // 退勤済
                $status = 'after_work';
            } else {
                $rest = $attendance->rests->whereNull("end_time")->first();

                if ($rest) {
                    // 休憩中
                    $status = 'resting';
                } else {
                    // 出勤中
                    $status = 'working';
                }
            }
        }

        return view('attendance.create', [
            'status' => $status,
            'now' => Carbon::now()->format('Y年m月d日 H:i:s')
        ]);


    }
    // 打刻画面表示。ここで画面変化を実装

    public function startAttendance()
    {
        $id = Auth::id();

        $dt = new Carbon();
        $date = $dt->toDateString();
        $time = $dt->toTimeString();

        Attendance::create([
            'user_id' => $id,
            'date' => $date,
            'start_time' => $time,
        ]);

        return redirect('attendance/create')->with('result', '
        勤務開始しました');
    }
    // 「出勤」ボタンを押したときの動作。

    public function endAttendance()
    {
        $id = Auth::id();

        $dt = new Carbon();
        $date = $dt->toDateString();
        $time = $dt->toTimeString();

        Attendance::where('user_id', $id)->where('date', $date)->update(['end_time' => $time]);

        return redirect('attendance/create')->with('result', '
        勤務終了しました');
    }
    // 「退勤」ボタンを押したときの動作。

    public function getList() {}
}
