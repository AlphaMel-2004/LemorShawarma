<?php

namespace Tests\Feature\Admin;

use App\Models\Location;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeliverySettingsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_delivery_settings_page(): void
    {
        $response = $this->get($this->adminUrl('/delivery'));

        $response->assertRedirect(route('login'));
    }

    public function test_admin_can_view_delivery_settings_page(): void
    {
        $admin = User::factory()->admin()->create();
        Location::factory()->create([
            'name' => 'Makati Branch',
            'latitude' => 14.5995,
            'longitude' => 120.9842,
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->get($this->adminUrl('/delivery'));

        $response->assertOk();
        $response->assertViewIs('admin.delivery.edit');
        $response->assertSee('Delivery Apps');
        $response->assertSee('Quick QR Links');
        $response->assertSee('Uber Eats');
        $response->assertSee('DoorDash');
        $response->assertSee('SkipTheDishes');
        $response->assertSee('Show app');
        $response->assertSee('Home');
        $response->assertSee('Locations');
        $response->assertSee('Menu');
        $response->assertSee('Reviews');
        $response->assertSee('id="qrToggleHome"', false);
        $response->assertSee('id="qrToggleLocations"', false);
        $response->assertSee('id="qrToggleMenu"', false);
        $response->assertSee('id="qrToggleFeedback"', false);
        $response->assertSee('id="qrPreviewImage"', false);
        $response->assertSee('data-qr-trigger="home"', false);
        $response->assertSee('data-qr-trigger="locations"', false);
        $response->assertSee('data-qr-trigger="menu"', false);
        $response->assertSee('data-qr-trigger="feedback"', false);
        $response->assertSee('google.com\\/maps\\/search\\/?api=1\\u0026query=14.5995,120.9842', false);
        $response->assertDontSee('id="copyFeedbackLinkBtn"', false);
    }

    public function test_admin_can_update_delivery_settings(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->put($this->adminUrl('/delivery'), [
            'delivery_ubereats_enabled' => '1',
            'delivery_ubereats_name' => 'Uber Eats PH',
            'delivery_ubereats_url' => 'https://www.ubereats.com/ph',
            'delivery_doordash_enabled' => '0',
            'delivery_doordash_name' => 'DoorDash',
            'delivery_doordash_url' => 'https://www.doordash.com',
            'delivery_skipthedishes_enabled' => '1',
            'delivery_skipthedishes_name' => 'SkipTheDishes',
            'delivery_skipthedishes_url' => 'https://www.skipthedishes.com',
        ]);

        $response->assertRedirect(route('admin.delivery.edit'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('site_settings', [
            'key' => 'delivery_ubereats_name',
            'value' => 'Uber Eats PH',
        ]);

        $this->assertDatabaseHas('site_settings', [
            'key' => 'delivery_ubereats_url',
            'value' => 'https://www.ubereats.com/ph',
        ]);

        $this->assertDatabaseHas('site_settings', [
            'key' => 'delivery_doordash_enabled',
            'value' => '0',
        ]);
    }

    public function test_admin_can_disable_app_without_revalidating_other_fields(): void
    {
        $admin = User::factory()->admin()->create();

        SiteSetting::setValue('delivery_ubereats_name', 'Uber Eats');
        SiteSetting::setValue('delivery_ubereats_url', 'https://www.ubereats.com');
        SiteSetting::setValue('delivery_doordash_name', 'DoorDash');
        SiteSetting::setValue('delivery_doordash_url', 'https://www.doordash.com');
        SiteSetting::setValue('delivery_skipthedishes_name', 'SkipTheDishes');
        SiteSetting::setValue('delivery_skipthedishes_url', 'https://www.skipthedishes.com');

        $response = $this->actingAs($admin)->put($this->adminUrl('/delivery'), [
            'delivery_doordash_enabled' => '0',
        ]);

        $response->assertRedirect(route('admin.delivery.edit'));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('site_settings', [
            'key' => 'delivery_doordash_enabled',
            'value' => '0',
        ]);
    }

    public function test_delivery_url_must_be_valid(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->put($this->adminUrl('/delivery'), [
            'delivery_ubereats_enabled' => '1',
            'delivery_ubereats_name' => 'Uber Eats',
            'delivery_ubereats_url' => 'not-a-url',
            'delivery_doordash_name' => 'DoorDash',
            'delivery_doordash_url' => 'https://www.doordash.com',
            'delivery_skipthedishes_name' => 'SkipTheDishes',
            'delivery_skipthedishes_url' => 'https://www.skipthedishes.com',
        ]);

        $response->assertSessionHasErrors('delivery_ubereats_url');
    }

    public function test_menu_page_only_renders_enabled_delivery_apps(): void
    {
        SiteSetting::setValue('delivery_ubereats_enabled', '1');
        SiteSetting::setValue('delivery_ubereats_name', 'Uber Eats');
        SiteSetting::setValue('delivery_ubereats_url', 'https://www.ubereats.com');
        SiteSetting::setValue('delivery_doordash_enabled', '0');
        SiteSetting::setValue('delivery_doordash_name', 'DoorDash');
        SiteSetting::setValue('delivery_doordash_url', 'https://www.doordash.com');
        SiteSetting::setValue('delivery_skipthedishes_enabled', '1');
        SiteSetting::setValue('delivery_skipthedishes_name', 'SkipTheDishes');
        SiteSetting::setValue('delivery_skipthedishes_url', 'https://www.skipthedishes.com');

        $response = $this->get($this->siteUrl('/menu'));

        $response->assertOk();
        $response->assertSee('ubereats');
        $response->assertSee('skipthedishes');
        $response->assertDontSee("openDeliveryApp('doordash')");
    }
}
