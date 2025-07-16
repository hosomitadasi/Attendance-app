<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EditRequest;
use App\Models\Attendance;
use App\Models\Rest;
use Illuminate\Support\Facades\DB;

class AdminRequestController extends Controller
{
    public function getRequest()
    {
        $pendingRequests = EditRequest::with(['user', 'attendance'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        $approvedRequests = EditRequest::with(['user', 'attendance'])
            ->where('status', 'approved')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.request_list', compact('pendingRequests', 'approvedRequests'));
    }

    public function getApprove($id)
    {
        $editRequest = EditRequest::with(['user', 'attendance'])->findOrFail($id);
        $newRests = json_decode($editRequest->new_rests, true);
        return view('admin.request_approve', compact('editRequest', 'newRests'));
    }

    public function approve(Request $request, $id)
    {
        DB::transaction(function () use ($id) {
            $editRequest = EditRequest::findOrFail($id);
            $attendance = $editRequest->attendance;

            $attendance->start_time = $editRequest->new_start_time;
            $attendance->end_time = $editRequest->new_end_time;
            $attendance->note = $editRequest->reason;
            $attendance->save();

            // 既存の休憩を削除して新規登録
            $attendance->rests()->delete();
            $newRests = json_decode($editRequest->new_rests, true);

            foreach ($newRests as $restData) {
                $attendance->rests()->create([
                    'start_time' => $restData['start_time'],
                    'end_time' => $restData['end_time'],
                ]);
            }

            $editRequest->status = 'approved';
            $editRequest->save();
        });

        return redirect()->route('admin.request_list')->with('message', '申請を承認しました');
    }
}
