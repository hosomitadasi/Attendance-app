<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;
use App\Models\Rest;

class RestsTableSeeder extends Seeder
{
    public function run()
    {
        $attendances = Attendance::where('date', '2025-06-01')->get();

        foreach ($attendances as $attendance) {
            Rest::create([
                'attendance_id' => $attendance->id,
                'start_time' => '12:00:00',
                'end_time' => '13:00:00'
            ]);
        }
    }
}
