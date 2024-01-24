<?php

namespace Tests\Feature\Auth;

use App\Models\Admin;
use App\Notifications\AdminResetPasswordNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AdminPasswordResetTest extends TestCase
{
    use RefreshDatabase;

    private Admin $admin;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->admin = Admin::factory()->create();
    }

    public function test_reset_password_link_screen_can_be_rendered(): void
    {
        $response = $this->get('/dashboard/forgot-password');

        $response->assertStatus(200);
    }

    public function test_reset_password_link_can_be_requested(): void
    {
        Notification::fake();

        $this->post('/dashboard/forgot-password', ['email' => $this->admin->email]);

        Notification::assertSentTo($this->admin, AdminResetPasswordNotification::class);
    }

    public function test_reset_password_screen_can_be_rendered(): void
    {
        Notification::fake();

        $this->post('/dashboard/forgot-password', ['email' => $this->admin->email]);

        Notification::assertSentTo($this->admin, AdminResetPasswordNotification::class, function ($notification) {
            $response = $this->get('/dashboard/reset-password/' . $notification->token);

            $response->assertStatus(200);

            return true;
        });
    }

    public function test_password_can_be_reset_with_valid_token(): void
    {
        Notification::fake();

        $this->post('/dashboard/forgot-password', ['email' => $this->admin->email]);

        Notification::assertSentTo($this->admin, AdminResetPasswordNotification::class, function ($notification) {
            $response = $this->post('/dashboard/reset-password', [
                'token' => $notification->token,
                'email' => $this->admin->email,
                'password' => 'password',
                'password_confirmation' => 'password',
            ]);

            $response->assertSessionHasNoErrors();

            return true;
        });
    }
}
