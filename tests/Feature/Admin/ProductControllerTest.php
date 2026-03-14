<?php

namespace Tests\Feature\Admin;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    // ── Index ──

    public function test_guest_cannot_access_products_index(): void
    {
        $response = $this->get($this->adminUrl('/products'));

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_products_index(): void
    {
        Product::factory()->count(3)->create();

        $response = $this->actingAs($this->admin)->get($this->adminUrl('/products'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.products.index');
        $response->assertViewHas('products');
    }

    public function test_products_index_paginates_at_ten_items(): void
    {
        Product::factory()->count(15)->create();

        $response = $this->actingAs($this->admin)->get($this->adminUrl('/products'));

        $response->assertStatus(200);
        $this->assertCount(10, $response->viewData('products'));
    }

    public function test_products_can_be_searched(): void
    {
        Product::factory()->create(['name' => 'Chicken Shawarma']);
        Product::factory()->create(['name' => 'Beef Kebab']);

        $response = $this->actingAs($this->admin)
            ->get($this->adminUrl('/products?search=Chicken'), [
                'X-Requested-With' => 'XMLHttpRequest',
                'Accept' => 'application/json',
            ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['html', 'pagination']);
    }

    public function test_products_can_be_filtered_by_status(): void
    {
        Product::factory()->count(3)->create(['is_active' => true]);
        Product::factory()->count(2)->create(['is_active' => false]);

        $response = $this->actingAs($this->admin)
            ->getJson($this->adminUrl('/products?status=active'));

        $response->assertStatus(200);
    }

    public function test_products_can_be_sorted(): void
    {
        Product::factory()->create(['name' => 'Zebra Wrap', 'price' => 100]);
        Product::factory()->create(['name' => 'Apple Pie', 'price' => 200]);

        $response = $this->actingAs($this->admin)
            ->getJson($this->adminUrl('/products?sort=name&direction=asc'));

        $response->assertStatus(200);
    }

    // ── Store ──

    public function test_product_can_be_created(): void
    {
        Storage::fake('public');

        $response = $this->actingAs($this->admin)->postJson($this->adminUrl('/products'), [
            'name' => 'New Shawarma',
            'description' => 'Delicious new item',
            'price' => 149.99,
            'is_active' => true,
            'image' => UploadedFile::fake()->image('product.jpg'),
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $this->assertDatabaseHas('products', ['name' => 'New Shawarma']);
        Storage::disk('public')->assertExists('products/'.basename(Product::first()->image));
    }

    public function test_product_creation_requires_name(): void
    {
        $response = $this->actingAs($this->admin)->postJson($this->adminUrl('/products'), [
            'price' => 100,
            'is_active' => true,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('name');
    }

    public function test_product_creation_requires_price(): void
    {
        $response = $this->actingAs($this->admin)->postJson($this->adminUrl('/products'), [
            'name' => 'Test Product',
            'is_active' => true,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('price');
    }

    public function test_product_creation_rejects_invalid_price(): void
    {
        $response = $this->actingAs($this->admin)->postJson($this->adminUrl('/products'), [
            'name' => 'Test Product',
            'price' => -10,
            'is_active' => true,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('price');
    }

    public function test_product_creation_rejects_oversized_image(): void
    {
        Storage::fake('public');

        $response = $this->actingAs($this->admin)->postJson($this->adminUrl('/products'), [
            'name' => 'Test Product',
            'price' => 100,
            'is_active' => true,
            'image' => UploadedFile::fake()->image('huge.jpg')->size(3000),
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('image');
    }

    // ── Edit ──

    public function test_product_can_be_retrieved_for_editing(): void
    {
        $product = Product::factory()->create();

        $response = $this->actingAs($this->admin)
            ->getJson($this->adminUrl("/products/{$product->id}/edit"));

        $response->assertStatus(200);
        $response->assertJsonFragment(['id' => $product->id]);
    }

    // ── Update ──

    public function test_product_can_be_updated(): void
    {
        $product = Product::factory()->create(['name' => 'Old Name']);

        $response = $this->actingAs($this->admin)
            ->putJson($this->adminUrl("/products/{$product->id}"), [
                'name' => 'Updated Name',
                'price' => 199.99,
                'is_active' => false,
            ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Name',
        ]);
    }

    public function test_product_image_can_be_updated(): void
    {
        Storage::fake('public');

        $product = Product::factory()->create(['image' => 'products/old.jpg']);
        Storage::disk('public')->put('products/old.jpg', 'old content');

        $response = $this->actingAs($this->admin)
            ->putJson($this->adminUrl("/products/{$product->id}"), [
                'name' => $product->name,
                'price' => $product->price,
                'is_active' => true,
                'image' => UploadedFile::fake()->image('new.jpg'),
            ]);

        $response->assertStatus(200);
        Storage::disk('public')->assertMissing('products/old.jpg');
    }

    // ── Destroy ──

    public function test_product_can_be_deleted(): void
    {
        $product = Product::factory()->create();

        $response = $this->actingAs($this->admin)
            ->deleteJson($this->adminUrl("/products/{$product->id}"));

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $this->assertSoftDeleted('products', ['id' => $product->id]);
    }

    public function test_guest_cannot_create_product(): void
    {
        $response = $this->postJson($this->adminUrl('/products'), [
            'name' => 'Hacked Product',
            'price' => 100,
            'is_active' => true,
        ]);

        $response->assertStatus(401);
    }

    public function test_guest_cannot_delete_product(): void
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson($this->adminUrl("/products/{$product->id}"));

        $response->assertStatus(401);
    }
}
