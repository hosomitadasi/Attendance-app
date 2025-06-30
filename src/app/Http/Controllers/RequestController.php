<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RequestController extends Controller
{
    public function getDetail()
    {
        return view('attendance.detail');
    }

    public function corrective()
    {}

    public function getRequest()
    {
        return view('attendance.request_list');
    }
}
