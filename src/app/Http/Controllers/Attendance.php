<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Attendance extends Controller
{
    public function create()
    {
        $attendance = Attendance::getAttendance();

        if (empty($attendance)) {
            return view('attendance.create');
        }

        $rest = $attendance->rests->whereNull("end_time")->first();

        if ($attendance->end_time) {
            return view('index')->with([
                "is_attendance_start" => true,
                "is_attendance_end" => true,
            ]);
        }

        if ($attendance->start_time) {
            if (isset($rest)) {
                return view('index')->with([
                    "is_rest" => true,
                    "is_attendance_start" => true,
                ]);
            } else {
                return view('index')->with([
                    "is_rest" => false,
                    "is_attendance_start" => true,
                ]);
            }
        }
    }
}
