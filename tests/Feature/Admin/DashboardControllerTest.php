<?php

namespace Tests\Feature\Admin;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    // ── Auth Guard ──

    public function test_guest_cannot_access_dashboard(): void
    {
        $response = $this->get($this->adminUrl('/'));

        $response->assertRedirect(route('login'));
    }

    // ── Dashboard View ──

    public function test_authenticated_user_can_view_dashboard(): void
    {
        $response = $this->actingAs($this->admin)->get($this->adminUrl('/'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.dashboard');
    }

    public function test_dashboard_displays_product_statistics(): void
    {
        Product::factory()->count(5)->create(['is_active' => true]);
        Product::factory()->count(2)->create(['is_active' => false]);

        $response = $this->actingAs($this->admin)->get($this->adminUrl('/'));

        $response->assertStatus(200);
        $response->assertViewHas('totalProducts', 7);
        $response->assertViewHas('activeProducts', 5);
        $response->assertViewHas('inactiveProducts', 2);
    }

    public function test_dashboard_displays_price_statistics(): void
    {
        Product::factory()->create(['price' => 100.00, 'is_active' => true]);
        Product::factory()->create(['price' => 200.00, 'is_active' => true]);
        Product::factory()->create(['price' => 50.00, 'is_active' => false]);

        $response = $this->actingAs($this->admin)->get($this->adminUrl('/'));

        $response->assertStatus(200);
        $response->assertViewHas('highestPrice');
        $response->assertViewHas('lowestPrice');
        $response->assertViewHas('averagePrice');
    }

    public function test_dashboard_displays_recent_products(): void
    {
        Product::factory()->count(8)->create();

        $response = $this->actingAs($this->admin)->get($this->adminUrl('/'));

        $response->assertStatus(200);
        $response->assertViewHas('recentProducts');

        $recentProducts = $response->viewData('recentProducts');
        $this->assertCount(5, $recentProducts);
    }

    public function test_dashboard_works_with_no_products(): void
    {
        $response = $this->actingAs($this->admin)->get($this->adminUrl('/'));

        $response->assertStatus(200);
        $response->assertViewHas('totalProducts', 0);
        $response->assertViewHas('activeProducts', 0);
        $response->assertViewHas('inactiveProducts', 0);
        $response->assertSee('No products yet');
    }

    public function test_dashboard_has_no_index_header(): void
    {
        $response = $this->actingAs($this->admin)->get($this->adminUrl('/'));

        $response->assertHeader('X-Robots-Tag', 'noindex, nofollow');
    }
}
