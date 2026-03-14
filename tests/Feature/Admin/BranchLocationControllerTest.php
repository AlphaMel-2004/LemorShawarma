<?php

namespace Tests\Feature\Admin;

use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BranchLocationControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    public function test_guest_cannot_access_branch_location_settings(): void
    {
        $response = $this->get('/admin/branch-locations');

        $response->assertRedirect('/admin/login');
    }

    public function test_guest_cannot_update_branch_location_settings(): void
    {
        $response = $this->put('/admin/branch-locations', [
            'branch_location_name' => 'City Center Branch',
            'branch_location_address' => '12 Market Street',
            'branch_location_phone' => '+63 912 345 6789',
            'branch_location_hours' => 'Daily: 10AM - 9PM',
            'branch_location_map_url' => 'https://maps.google.com/?q=12+Market+Street',
            'branch_location_image_url' => 'https://example.com/branch.jpg',
        ]);

        $response->assertRedirect('/admin/login');
    }

    public function test_authenticated_user_can_view_branch_location_settings(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/branch-locations');

        $response->assertStatus(200);
        $response->assertViewIs('admin.branch-locations.edit');
        $response->assertViewHas('settings');
    }

    public function test_branch_location_edit_page_shows_default_values_when_no_settings_exist(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/branch-locations');

        $response->assertStatus(200);
        $response->assertSee('Downtown Flagship');
        $response->assertSee('https://maps.google.com/?q=123+Golden+Avenue,+Downtown+District');
    }

    public function test_branch_location_edit_page_has_noindex_header(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/branch-locations');

        $response->assertHeader('X-Robots-Tag', 'noindex, nofollow');
    }

    public function test_branch_location_settings_can_be_updated(): void
    {
        $response = $this->actingAs($this->admin)->put('/admin/branch-locations', [
            'branch_location_name' => 'City Center Branch',
            'branch_location_address' => '12 Market Street, Cebu City',
            'branch_location_phone' => '+63 912 345 6789',
            'branch_location_hours' => 'Daily: 10AM - 9PM',
            'branch_location_map_url' => 'https://maps.google.com/?q=12+Market+Street,+Cebu+City',
            'branch_location_image_url' => 'https://example.com/branch.jpg',
        ]);

        $response->assertRedirect(route('admin.branch-locations.edit'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('site_settings', [
            'key' => 'branch_location_name',
            'value' => 'City Center Branch',
        ]);
        $this->assertDatabaseHas('site_settings', [
            'key' => 'branch_location_map_url',
            'value' => 'https://maps.google.com/?q=12+Market+Street,+Cebu+City',
        ]);
    }

    public function test_branch_location_update_validates_required_fields(): void
    {
        $response = $this->actingAs($this->admin)->put('/admin/branch-locations', [
            'branch_location_name' => '',
            'branch_location_address' => '',
            'branch_location_phone' => '',
            'branch_location_hours' => '',
            'branch_location_map_url' => '',
            'branch_location_image_url' => '',
        ]);

        $response->assertSessionHasErrors([
            'branch_location_name',
            'branch_location_address',
            'branch_location_phone',
            'branch_location_hours',
            'branch_location_map_url',
            'branch_location_image_url',
        ]);
    }

    public function test_branch_location_update_validates_urls(): void
    {
        $response = $this->actingAs($this->admin)->put('/admin/branch-locations', [
            'branch_location_name' => 'City Center Branch',
            'branch_location_address' => '12 Market Street, Cebu City',
            'branch_location_phone' => '+63 912 345 6789',
            'branch_location_hours' => 'Daily: 10AM - 9PM',
            'branch_location_map_url' => 'not-a-url',
            'branch_location_image_url' => 'also-not-a-url',
        ]);

        $response->assertSessionHasErrors([
            'branch_location_map_url',
            'branch_location_image_url',
        ]);
    }

    public function test_homepage_displays_saved_branch_location_settings(): void
    {
        SiteSetting::setValue('branch_location_name', 'IT Park Branch');
        SiteSetting::setValue('branch_location_address', 'Garden Row, Cebu IT Park');
        SiteSetting::setValue('branch_location_phone', '+63 998 111 2233');
        SiteSetting::setValue('branch_location_hours', 'Daily: 9AM - 11PM');
        SiteSetting::setValue('branch_location_map_url', 'https://maps.google.com/?q=Cebu+IT+Park');

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('IT Park Branch');
        $response->assertSee('Garden Row, Cebu IT Park');
        $response->assertSee('https://maps.google.com/?q=Cebu+IT+Park', false);
    }
}
