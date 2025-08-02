<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class AttendanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_start_attendance()
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user);

        $response = $this->post(route('attendance.start'));

        $response->assertRedirect(route('attendance.create'));
        $this->assertDatabaseHas('attendances', [
            'user_id' => $user->id,
            'date' => Carbon::now()->toDateString(),
        ]);
    }

    public function test_user_can_end_attendance()
    {
        $user = User::factory()->create(['role' => 'user']);
        Attendance::factory()->create([
            'user_id' => $user->id,
            'date' => Carbon::now()->toDateString(),
        ]);
        $this->actingAs($user);

        $response = $this->post(route('attendance.end'));

        $response->assertRedirect(route('attendance.create'));
        $this->assertNotNull(Attendance::first()->end_time);
    }
}
