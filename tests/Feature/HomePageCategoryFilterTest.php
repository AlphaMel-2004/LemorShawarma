<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageCategoryFilterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Ensure category filters are rendered from active product categories.
     */
    public function test_homepage_renders_category_filter_tabs_from_active_products(): void
    {
        Product::factory()->create(['is_active' => true, 'category' => 'Wraps']);
        Product::factory()->create(['is_active' => true, 'category' => 'Rice Bowls']);
        Product::factory()->create(['is_active' => false, 'category' => 'Hidden Category']);

        $response = $this->get($this->siteUrl('/'));

        $response->assertStatus(200);
        $response->assertSee('data-filter="all"', false);
        $response->assertSee('data-filter="wraps"', false);
        $response->assertSee('data-filter="rice-bowls"', false);
        $response->assertDontSee('data-filter="hidden-category"', false);
    }

    public function test_footer_shows_only_top_five_categories_by_active_product_count(): void
    {
        Product::factory()->count(6)->create(['is_active' => true, 'category' => 'Wraps']);
        Product::factory()->count(5)->create(['is_active' => true, 'category' => 'Rice Bowls']);
        Product::factory()->count(4)->create(['is_active' => true, 'category' => 'Platters']);
        Product::factory()->count(3)->create(['is_active' => true, 'category' => 'Sides']);
        Product::factory()->count(2)->create(['is_active' => true, 'category' => 'Beverages']);
        Product::factory()->count(1)->create(['is_active' => true, 'category' => 'Desserts']);
        Product::factory()->count(8)->create(['is_active' => false, 'category' => 'Hidden Category']);

        $response = $this->get($this->siteUrl('/'));

        $response->assertStatus(200);

        $content = $response->getContent();
        $menuColumnStart = strpos($content, '<h4 class="footer-title">Menu</h4>');

        $this->assertNotFalse($menuColumnStart);

        $menuColumnHtml = substr($content, $menuColumnStart, 1200);

        $this->assertStringContainsString('>Wraps<', $menuColumnHtml);
        $this->assertStringContainsString('>Rice Bowls<', $menuColumnHtml);
        $this->assertStringContainsString('>Platters<', $menuColumnHtml);
        $this->assertStringContainsString('>Sides<', $menuColumnHtml);
        $this->assertStringContainsString('>Beverages<', $menuColumnHtml);
        $this->assertStringNotContainsString('>Desserts<', $menuColumnHtml);
        $this->assertStringNotContainsString('>Hidden Category<', $menuColumnHtml);
    }
}
