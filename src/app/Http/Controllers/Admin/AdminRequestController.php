<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminRequestController extends Controller
{
    public function getRequest()
    {
        return view('admin.request_list');
    }

    public function getApprove()
    {
        return view('admin.request_approve');
    }

    public function approve() {}
}
