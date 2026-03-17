<?php

namespace Tests\Feature\Admin;

use App\Models\Location;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocationControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->admin()->create();
    }

    public function test_admin_can_store_location_with_structured_hours_value(): void
    {
        $response = $this->actingAs($this->admin)->post($this->adminUrl('/locations'), [
            'name' => 'Test Branch',
            'address' => '123 Test Street',
            'phone' => '+63 900 000 0000',
            'hours' => 'Mon-Fri: 11AM - 11PM',
            'latitude' => 14.5995,
            'longitude' => 120.9842,
            'is_active' => true,
        ]);

        $response->assertRedirect(route('admin.locations.index'));
        $response->assertSessionHas('status', 'Location created successfully.');

        $this->assertDatabaseHas('locations', [
            'name' => 'Test Branch',
            'hours' => 'Mon-Fri: 11AM - 11PM',
        ]);
    }

    public function test_location_store_requires_hours_value(): void
    {
        $response = $this->actingAs($this->admin)->post($this->adminUrl('/locations'), [
            'name' => 'No Hours Branch',
            'address' => '456 Validation Street',
            'phone' => '+63 911 111 1111',
            'hours' => '',
            'latitude' => 14.7000,
            'longitude' => 121.0000,
            'is_active' => true,
        ]);

        $response->assertSessionHasErrors(['hours']);
        $this->assertDatabaseCount('locations', 0);
    }

    public function test_guest_cannot_store_location(): void
    {
        $response = $this->post($this->adminUrl('/locations'), [
            'name' => 'Guest Branch',
            'address' => 'Guest Street',
            'phone' => '+63 922 222 2222',
            'hours' => 'Mon-Sun: 11AM - 11PM',
            'latitude' => 14.6000,
            'longitude' => 120.9900,
            'is_active' => true,
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseMissing('locations', [
            'name' => 'Guest Branch',
        ]);
    }

    public function test_location_index_displays_hours_column_value(): void
    {
        Location::factory()->create([
            'name' => 'Display Branch',
            'hours' => 'Tue-Sun: 09AM - 06PM',
        ]);

        $response = $this->actingAs($this->admin)->get($this->adminUrl('/locations'));

        $response->assertOk();
        $response->assertSee('Display Branch');
        $response->assertSee('data-hours="Tue-Sun: 09AM - 06PM"', false);
        $response->assertSee('data-time-picker-trigger="locationHoursOpen-add-location"', false);
        $response->assertSee('data-time-picker-trigger="locationHoursClose-add-location"', false);
    }
}
