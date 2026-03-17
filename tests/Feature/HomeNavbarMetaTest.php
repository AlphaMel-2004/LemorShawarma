<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeNavbarMetaTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Ensure homepage hero shows live open status and address details.
     */
    public function test_homepage_shows_live_open_badge_and_address_in_hero(): void
    {
        $this->travelTo(CarbonImmutable::parse('2026-03-17 12:00:00', 'UTC'));
        SiteSetting::setValue('contact_hours', 'Mon-Sun: 12AM - 11:59PM');
        SiteSetting::setValue('contact_address_line1', '789 New Avenue');
        SiteSetting::setValue('contact_address_line2', 'Uptown District, CA 90001');

        $response = $this->get($this->siteUrl('/'));

        $response->assertStatus(200);
        $response->assertSee('Open now');
        $response->assertSee('Closes 11:59 PM');
        $response->assertSee('789 New Avenue, Uptown District, CA 90001');
        $response->assertSee('id="heroLiveBadge"', false);
        $response->assertSee('id="heroOpenStatusText"', false);
        $response->assertSee('id="heroNextTimeLabel"', false);
        $response->assertSee('data-hero-schedule=', false);
    }

    public function test_homepage_shows_closed_state_for_current_time(): void
    {
        $this->travelTo(CarbonImmutable::parse('2026-03-17 03:00:00', 'UTC'));
        SiteSetting::setValue('contact_hours', 'Mon-Sun: 6AM - 11PM');

        $response = $this->get($this->siteUrl('/'));

        $response->assertStatus(200);
        $response->assertSee('Closed now');
        $response->assertSee('Opens 6:00 AM');
    }
}
