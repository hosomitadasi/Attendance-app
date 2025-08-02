<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Attendance;
use App\Models\EditRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminRequestApprovalTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_approve_edit_request()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);
        $attendance = Attendance::factory()->create(['user_id' => $user->id]);

        $editRequest = EditRequest::create([
            'attendance_id' => $attendance->id,
            'user_id' => $user->id,
            'new_start_time' => '10:00',
            'new_end_time' => '19:00',
            'new_rests' => [['start_time' => '13:00', 'end_time' => '14:00']],
            'note' => '体調不良で遅刻',
            'status' => 'pending',
        ]);

        $this->actingAs($admin, 'admin');

        $response = $this->post("/admin/request/{$editRequest->id}");

        $response->assertRedirect();
        $this->assertDatabaseHas('edit_requests', [
            'id' => $editRequest->id,
            'status' => 'approved',
        ]);
        $this->assertEquals('10:00:00', $attendance->fresh()->start_time);
    }
}
