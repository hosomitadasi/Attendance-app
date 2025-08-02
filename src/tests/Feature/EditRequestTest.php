<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class EditRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_submit_edit_request()
    {
        $user = User::factory()->create(['role' => 'user']);
        $attendance = Attendance::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        $response = $this->post(route('attendance.update', $attendance->id), [
            'new_start_time' => '09:30',
            'new_end_time' => '18:30',
            'new_rests' => [['start_time' => '12:30', 'end_time' => '13:30']],
            'note' => '遅延対応のため',
        ]);

        $response->assertRedirect(route('attendance.index'));
        $this->assertDatabaseHas('edit_requests', [
            'attendance_id' => $attendance->id,
            'user_id' => $user->id,
            'new_start_time' => '09:30:00',
            'note' => '遅延対応のため',
            'status' => 'pending',
        ]);
    }
}
