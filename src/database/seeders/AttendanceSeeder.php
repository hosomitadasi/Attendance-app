<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;

class AttendanceSeeder extends Seeder
{
    public function run()
    {
        $users = User::whereIn('name', [
            '山田 太郎', '西 玲奈', '増田 一世', '山本 敬吉', '秋田 朋美', '中西 教夫'
        ])->get();

        foreach ($users as $user) {
            Attendance::create([
                'user_id' => $user->id,
                'date'=> '2025-06-01',
                'start_time' => '09:00:00',
                'end_time' => '18:00:00',
                'note' => null,
            ]);
        }
    }
}
