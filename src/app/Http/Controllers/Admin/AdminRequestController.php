<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\EditRequest;
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
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('admin.request_list', compact('pendingRequests', 'approvedRequests'));
    }

    public function getApprove($id)
    {
        $editRequest = EditRequest::with(['user', 'attendance'])->findOrFail($id);
        $newRests = json_decode($editRequest->new_rests, true);
        return view('admin.request_approve', compact('editRequest', 'newRests'));
    }

    public function approve($id)
    {
        $editRequest = EditRequest::findOrFail($id);
        $attendance = $editRequest->attendance;

        if ($editRequest->new_start_time) {
            $attendance->start_time = $editRequest->new_start_time;
        }
        if ($editRequest->new_end_time) {
            $attendance->end_time = $editRequest->new_end_time;
        }
        if (!empty($editRequest->new_rests)) {
            // 既存の休憩を削除し、新しく登録
            $attendance->rests()->delete();
            foreach ($editRequest->new_rests as $rest) {
                $attendance->rests()->create([
                    'start_time' => $rest['start_time'],
                    'end_time' => $rest['end_time'],
                ]);
            }
        }

        $attendance->save();
        $editRequest->status = 'approved';
        $editRequest->save();

        return redirect()->back()->with('success', '申請を承認しました。');
    }
}
