<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * メール認証済みユーザーが正常にログインできること
     */
    public function test_verified_user_can_login_successfully()
    {
        $user = User::factory()->create([
            'email' => 'reina.n@coachtech.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(), // 認証済み
            'role' => 'user',
        ]);

        $response = $this->post('/login', [
            'email' => 'reina.n@coachtech.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/attendance'); // ログイン後の遷移先
        $this->assertAuthenticatedAs($user);
    }

    /**
     * メール未認証のユーザーがログインすると認証要求画面にリダイレクトされること
     */
    public function test_unverified_user_redirects_to_email_verification()
    {
        $user = User::factory()->unverified()->create([
            'email' => 'unverified@coachtech.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'unverified@coachtech.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/attendance');
        $followup = $this->get('/attendance');
        $followup->assertRedirect('/email/verify');

        $this->assertAuthenticatedAs($user);
    }

    /**
     * パスワードが間違っているとログインできないこと
     */
    public function test_login_fails_with_invalid_password()
    {
        $user = User::factory()->create([
            'email' => 'reina.n@coachtech.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
            'role' => 'user',
        ]);

        $response = $this->post('/login', [
            'email' => 'reina.n@coachtech.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('email'); // Laravel Fortifyでは 'email' にエラーが付く
        $this->assertGuest();
    }

    /**
     * 存在しないユーザーではログインできないこと
     */
    public function test_login_fails_with_nonexistent_user()
    {
        $response = $this->post('/login', [
            'email' => 'noone@coachtech.com',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }
}
