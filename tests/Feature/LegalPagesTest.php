<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LegalPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_privacy_policy_page_loads(): void
    {
        $response = $this->get(route('legal.privacy'));

        $response->assertStatus(200);
        $response->assertSee('Privacy Policy');
    }

    public function test_terms_of_service_page_loads(): void
    {
        $response = $this->get(route('legal.terms'));

        $response->assertStatus(200);
        $response->assertSee('Terms of Service');
    }

    public function test_cookie_policy_page_loads(): void
    {
        $response = $this->get(route('legal.cookies'));

        $response->assertStatus(200);
        $response->assertSee('Cookie Policy');
    }

    public function test_privacy_policy_uses_dynamic_admin_configured_content(): void
    {
        SiteSetting::setValue('legal_last_updated', 'April 1, 2026');
        SiteSetting::setValue('legal_privacy_intro', 'Custom privacy intro from admin.');
        SiteSetting::setValue('legal_privacy_summary', "Dynamic summary line one\nDynamic summary line two");
        SiteSetting::setValue('legal_privacy_content', "## 1. Dynamic Scope\nDynamic content from admin panel.");

        $response = $this->get(route('legal.privacy'));

        $response->assertStatus(200);
        $response->assertSee('April 1, 2026');
        $response->assertSee('Custom privacy intro from admin.');
        $response->assertSee('Dynamic summary line one');
        $response->assertSee('Dynamic Scope');
        $response->assertSee('Dynamic content from admin panel.');
    }
}
