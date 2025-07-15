<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Attendance;
use App\Models\EditRequest;

class EditRequestsTableSeeder extends Seeder
{
    public function run()
    {
        $requests = [
            ['name' => '西 伶奈', 'target_date' => '2025-06-01', 'request_date' => '2025-06-02'],
            ['name' => '山田 太郎', 'target_date' => '2025-06-01', 'request_date' => '2025-07-02'],
            ['name' => '山田 花子', 'target_date' => '2025-06-02', 'request_date' => '2025-07-02'],
        ];

        foreach ($requests as $req) {
            $user = User::where('name', $req['name'])->first();
            $attendance = Attendance::where('user_id', $user->id)
                ->where('date', $req['target_date'])
                ->first();

            if ($attendance) {
                EditRequest::create([
                    'user_id' => $user->id,
                    'attendance_id' => $attendance->id,
                    'new_start_time' => '09:30:00',
                    'new_end_time' => '18:30:00',
                    'new_rests' => json_encode([
                        ['start_time' => '12:30:00', 'end_time' => '13:30:00']
                    ]),
                    'reason' => '遅延のため',
                    'status' => 'pending',
                    'created_at' => $req['request_date'],
                    'updated_at' => $req['request_date'],
                ]);
            }
        }
    }
}
