<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_is_accessible_to_guests(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertViewIs('admin.login');
    }

    public function test_login_page_adds_noindex_header(): void
    {
        // Login page has its own inline noindex meta — no middleware on this route
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('noindex, nofollow');
    }

    public function test_authenticated_user_is_redirected_away_from_login(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get(route('login'))
            ->assertRedirect(route('admin.dashboard'));
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create();

        $this->post(route('admin.login.submit'), [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_login_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post(route('admin.login.submit'), [
            'email' => $user->email,
            'password' => 'wrong-password',
        ])->assertRedirect()
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_user_cannot_login_with_unknown_email(): void
    {
        $this->post(route('admin.login.submit'), [
            'email' => 'nobody@example.com',
            'password' => 'password',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_login_validates_required_fields(): void
    {
        $this->post(route('admin.login.submit'), [])
            ->assertSessionHasErrors(['email', 'password']);
    }

    public function test_user_can_logout(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->post(route('admin.logout'))
            ->assertRedirect(route('login'));

        $this->assertGuest();
    }
}
