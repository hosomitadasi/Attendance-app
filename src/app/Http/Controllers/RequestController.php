<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\EditRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RequestController extends Controller
{
    public function getDetail($id)
    {
        $attendance = Attendance::with('rests', 'user')->findOrFail($id);
        return view('attendance.detail', compact('attendance'));
    }

    public function corrective(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);

        EditRequest::create([
            'attendance_id' => $attendance->id,
            'user_id' => Auth::id(),
            'new_start_time' => $request->start_time,
            'new_end_time' => $request->end_time,
            'new_rests' => json_encode($request->rest),
            'note' => $request->note,
        ]);

        return redirect()->route('attendance.request_list')->with('result', '修正申請を送信しました');
    }

    public function getRequest(Request $request)
    {
        $tab = $request->query('tab', 'pending');

        $query = Request::where('user_id', Auth::id());

        if ($tab === 'pending') {
            $query->where('status', 'pending');
        } else {
            $query->whereIn('status', ['approved', 'rejected']);
        }

        $requests = $query->with('attendance')->orderBy('created_at', 'desc')->get();

        return view('attendance.request_list', compact('requests', 'tab'));
    }
}
