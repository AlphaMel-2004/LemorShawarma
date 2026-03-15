<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_is_accessible(): void
    {
        $response = $this->get($this->adminUrl('/login'));

        $response->assertStatus(200);
        $response->assertSee('Admin Login');
    }

    public function test_authenticated_user_is_redirected_from_login_page(): void
    {
        $user = User::factory()->admin()->create();

        $response = $this->actingAs($user)->get($this->adminUrl('/login'));

        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->admin()->create([
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post($this->adminUrl('/login'), [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_user_can_login_with_remember_me_checked(): void
    {
        $user = User::factory()->admin()->create([
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post($this->adminUrl('/login'), [
            'email' => $user->email,
            'password' => 'password123',
            'remember' => '1',
        ]);

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_user_cannot_login_with_invalid_credentials(): void
    {
        $user = User::factory()->admin()->create([
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post($this->adminUrl('/login'), [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    public function test_login_requires_email(): void
    {
        $response = $this->post($this->adminUrl('/login'), [
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_login_requires_password(): void
    {
        $response = $this->post($this->adminUrl('/login'), [
            'email' => 'admin@example.com',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_user_can_logout(): void
    {
        $user = User::factory()->admin()->create();

        $response = $this->actingAs($user)->post($this->adminUrl('/logout'));

        $this->assertGuest();
        $response->assertRedirect(route('login'));
    }

    public function test_non_admin_user_cannot_login_to_admin_portal(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post($this->adminUrl('/login'), [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }
}
