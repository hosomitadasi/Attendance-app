<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;
use App\Models\User;
use App\Models\Rest;
use Carbon\Carbon;

class AttendancesTableSeeder extends Seeder
{
    public function run()
    {
        $users = User::where('role', 'user')->get();

        foreach ($users as $user) {
            for ($i = 1; $i <= 30; $i++) {
                $date = \Carbon\Carbon::create(2025, 6, $i);
                if ($date->isWeekend()) continue;

                $attendance = Attendance::create([
                    'user_id' => $user->id,
                    'date' => $date->toDateString(),
                    'start_time' => '09:00:00',
                    'end_time' => '18:00:00',
                    'note' => null,
                ]);

                Rest::create([
                    'attendance_id' => $attendance->id,
                    'start_time' => '12:00:00',
                    'end_time' => '13:00:00',
                ]);
            }
        }
    }
}
