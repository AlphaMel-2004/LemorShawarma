<?php

namespace Tests\Feature\Admin;

use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->admin()->create();
    }

    // ── Auth Guard ──

    public function test_guest_cannot_access_contact_settings(): void
    {
        $response = $this->get($this->adminUrl('/contacts'));

        $response->assertRedirect(route('login'));
    }

    public function test_guest_cannot_update_contact_settings(): void
    {
        $response = $this->put($this->adminUrl('/contacts'), [
            'contact_address_line1' => '999 Test Street',
            'contact_phone' => '+1 (555) 999-9999',
            'contact_email' => 'test@example.com',
            'contact_hours' => 'Mon - Fri: 9AM - 5PM',
        ]);

        $response->assertRedirect(route('login'));
    }

    // ── Edit Page ──

    public function test_authenticated_user_can_view_contact_settings(): void
    {
        $response = $this->actingAs($this->admin)->get($this->adminUrl('/contacts'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.contacts.edit');
        $response->assertViewHas('settings');
        $response->assertSee('data-time-picker-trigger="contactHoursOpen"', false);
        $response->assertSee('data-time-picker-trigger="contactHoursClose"', false);
    }

    public function test_contact_edit_page_shows_default_values_when_no_settings_exist(): void
    {
        $response = $this->actingAs($this->admin)->get($this->adminUrl('/contacts'));

        $response->assertStatus(200);
        $response->assertSee('123 Royal Avenue');
        $response->assertSee('+1 (555) 123-4567');
    }

    public function test_contact_edit_page_shows_saved_values(): void
    {
        SiteSetting::setValue('contact_address_line1', '456 Custom Street');
        SiteSetting::setValue('contact_phone', '+1 (555) 999-0000');

        $response = $this->actingAs($this->admin)->get($this->adminUrl('/contacts'));

        $response->assertStatus(200);
        $response->assertSee('456 Custom Street');
        $response->assertSee('+1 (555) 999-0000');
    }

    public function test_contact_edit_page_has_noindex_header(): void
    {
        $response = $this->actingAs($this->admin)->get($this->adminUrl('/contacts'));

        $response->assertHeader('X-Robots-Tag', 'noindex, nofollow');
    }

    // ── Update ──

    public function test_contact_settings_can_be_updated(): void
    {
        $response = $this->actingAs($this->admin)->put($this->adminUrl('/contacts'), [
            'contact_address_line1' => '789 New Avenue',
            'contact_address_line2' => 'Uptown, CA 90001',
            'contact_phone' => '+1 (555) 777-8888',
            'contact_email' => 'new@pitaqueenhub.com',
            'contact_hours' => 'Mon - Sat: 10AM - 10PM',
        ]);

        $response->assertRedirect(route('admin.contacts.edit'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('site_settings', [
            'key' => 'contact_address_line1',
            'value' => '789 New Avenue',
        ]);
        $this->assertDatabaseHas('site_settings', [
            'key' => 'contact_phone',
            'value' => '+1 (555) 777-8888',
        ]);
        $this->assertDatabaseHas('site_settings', [
            'key' => 'contact_email',
            'value' => 'new@pitaqueenhub.com',
        ]);
    }

    public function test_contact_update_validates_required_fields(): void
    {
        $response = $this->actingAs($this->admin)->put($this->adminUrl('/contacts'), [
            'contact_address_line1' => '',
            'contact_phone' => '',
            'contact_email' => '',
            'contact_hours' => '',
        ]);

        $response->assertSessionHasErrors([
            'contact_address_line1',
            'contact_phone',
            'contact_email',
            'contact_hours',
        ]);
    }

    public function test_contact_update_validates_email_format(): void
    {
        $response = $this->actingAs($this->admin)->put($this->adminUrl('/contacts'), [
            'contact_address_line1' => '123 Street',
            'contact_phone' => '+1 (555) 123-4567',
            'contact_email' => 'not-an-email',
            'contact_hours' => 'Mon - Sun: 11AM - 11PM',
        ]);

        $response->assertSessionHasErrors(['contact_email']);
    }

    public function test_address_line2_is_optional(): void
    {
        $response = $this->actingAs($this->admin)->put($this->adminUrl('/contacts'), [
            'contact_address_line1' => '789 New Avenue',
            'contact_address_line2' => '',
            'contact_phone' => '+1 (555) 777-8888',
            'contact_email' => 'new@pitaqueenhub.com',
            'contact_hours' => 'Mon - Sat: 10AM - 10PM',
        ]);

        $response->assertRedirect(route('admin.contacts.edit'));
        $response->assertSessionHasNoErrors();
    }

    // ── Frontend Integration ──

    public function test_homepage_displays_saved_contact_settings(): void
    {
        SiteSetting::setValue('contact_phone', '+63 (999) 888-7777');
        SiteSetting::setValue('contact_email', 'custom@test.com');

        $response = $this->get($this->siteUrl('/'));

        $response->assertStatus(200);
        $response->assertSee('+63 (999) 888-7777');
        $response->assertSee('custom@test.com');
    }
}
