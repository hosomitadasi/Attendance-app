<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminStaffController extends Controller
{
    public function getStaffList()
    {
        return view('admin.staff_list');
    }

    public function getAttendance()
    {
        return view('admin.staff_attendance');
    }

    public function getList()
    {
        return view('admin.attendance_list');
    }

    public function getDetail()
    {
        return view('admin.attendance_detail');
    }

    public function corrective()
    {
    }
}
