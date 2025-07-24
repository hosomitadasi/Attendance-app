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
                $status = 'after_work';
            } else {
                $rest = $attendance->rests->whereNull("end_time")->first();

                if ($rest) {
                    $status = 'resting';
                } else {
                    $status = 'working';
                }
            }
        }

        $statusLabels = [
            'before_work' => '未出勤',
            'working' => '出勤中',
            'resting' => '休憩中',
            'after_work' => '退勤済',
        ];

        return view('attendance.create', [
            'status' => $status,
            'statusLabel' => $statusLabels[$status],
            'date' => Carbon::now()->format('Y年m月d日'),
            'time' => Carbon::now()->format('H:i'),
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

        return redirect()->route('attendance.create')->with('result', '
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

        return redirect()->route('attendance.create')->with('result', '
        勤務終了しました');
    }
    // 「退勤」ボタンを押したときの動作。

    public function getList(Request $request)
    {
        // ① 対象月を取得
        $targetMonth = $request->input('month', Carbon::now()->format('Y-m'));

        // ② ユーザーID
        $userId = Auth::id();

        // ③ その月の開始日・終了日
        $startOfMonth = Carbon::parse($targetMonth)->startOfMonth();
        $endOfMonth   = Carbon::parse($targetMonth)->endOfMonth();

        // ④ その月の勤怠を取得し、「日付」をキーにしてコレクション化
        $attendances = Attendance::with('rests')
            ->where('user_id', $userId)
            ->whereBetween('date', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
            ->get()
            ->keyBy('date');

        // ⑤ その月の日付を１日〜末日まで生成
        $dates = collect();
        for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addDay()) {
            $dates->push($date->copy());
        }

        // ⑥ ビューへ
        return view('attendance.list', [
            'dates'       => $dates,
            'attendances' => $attendances,
            'targetMonth' => $targetMonth,
        ]);
    }
}
