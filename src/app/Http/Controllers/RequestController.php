<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\EditRequest;
use App\Http\Requests\EditRequestForm;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RequestController extends Controller
{
    public function getDetail($id)
    {
        $attendance = Attendance::with('rests', 'user')->find($id);

        if (!$attendance) {
            abort(404, '該当の勤怠データが見つかりません');
        }

        return view('attendance.detail', compact('attendance'));
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

    public function getRequest(Request $request)
    {
        $tab = $request->query('tab', 'pending');

        $query = EditRequest::where('user_id', Auth::id());

        if ($tab === 'pending') {
            $query->where('status', 'pending');
        } else {
            $query->whereIn('status', ['approved', 'rejected']);
        }

        $requests = $query->with('attendance')->orderBy('created_at', 'desc')->get();

        return view('attendance.request_list', compact('requests', 'tab'));
    }
}
