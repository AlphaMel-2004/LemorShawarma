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

    /**
     * Authenticated user helper.
     */
    private function authenticatedUser(): User
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        return $user;
    }

    // -------------------------------------------------------
    // Authentication Guard
    // -------------------------------------------------------

    public function test_guests_are_redirected_to_login(): void
    {
        $this->get(route('admin.products.index'))
            ->assertRedirect(route('login'));
    }

    // -------------------------------------------------------
    // Index
    // -------------------------------------------------------

    public function test_authenticated_user_can_view_products_page(): void
    {
        $this->authenticatedUser();
        Product::factory()->count(3)->create();

        $this->get(route('admin.products.index'))
            ->assertStatus(200)
            ->assertViewIs('admin.products.index')
            ->assertViewHas('products');
    }

    public function test_index_returns_json_for_ajax_requests(): void
    {
        $this->authenticatedUser();
        Product::factory()->count(3)->create();

        $this->get(route('admin.products.index'), [
            'X-Requested-With' => 'XMLHttpRequest',
            'Accept' => 'application/json',
        ])
            ->assertOk()
            ->assertJsonStructure(['html', 'pagination']);
    }

    public function test_products_can_be_searched(): void
    {
        $this->authenticatedUser();
        Product::factory()->create(['name' => 'Chicken Shawarma']);
        Product::factory()->create(['name' => 'Beef Kebab']);

        $this->getJson(route('admin.products.index', ['search' => 'Chicken']))
            ->assertOk()
            ->assertSee('Chicken Shawarma')
            ->assertDontSee('Beef Kebab');
    }

    public function test_index_response_includes_x_robots_tag_header(): void
    {
        $this->authenticatedUser();

        $this->get(route('admin.products.index'))
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow');
    }

    // -------------------------------------------------------
    // Store
    // -------------------------------------------------------

    public function test_product_can_be_created(): void
    {
        $this->authenticatedUser();
        Storage::fake('public');

        $response = $this->postJson(route('admin.products.store'), [
            'name' => 'Classic Shawarma',
            'description' => 'Delicious chicken shawarma wrap.',
            'price' => 12.99,
            'is_active' => true,
            'image' => UploadedFile::fake()->image('shawarma.jpg'),
        ]);

        $response->assertOk()
            ->assertJson(['success' => true]);

        $this->assertDatabaseHas('products', [
            'name' => 'Classic Shawarma',
            'price' => 12.99,
        ]);

        Storage::disk('public')->assertExists(
            Product::first()->image
        );
    }

    public function test_product_can_be_created_without_image(): void
    {
        $this->authenticatedUser();

        $this->postJson(route('admin.products.store'), [
            'name' => 'No Image Product',
            'price' => 5.50,
            'is_active' => true,
        ])->assertOk()
            ->assertJson(['success' => true]);

        $this->assertDatabaseHas('products', ['name' => 'No Image Product']);
    }

    public function test_store_validation_errors_are_returned(): void
    {
        $this->authenticatedUser();

        $this->postJson(route('admin.products.store'), [])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'price', 'is_active']);
    }

    public function test_store_rejects_invalid_image_type(): void
    {
        $this->authenticatedUser();

        $this->postJson(route('admin.products.store'), [
            'name' => 'Test',
            'price' => 10,
            'is_active' => true,
            'image' => UploadedFile::fake()->create('document.pdf', 100, 'application/pdf'),
        ])->assertStatus(422)
            ->assertJsonValidationErrors(['image']);
    }

    // -------------------------------------------------------
    // Edit
    // -------------------------------------------------------

    public function test_product_edit_returns_json(): void
    {
        $this->authenticatedUser();
        $product = Product::factory()->create();

        $this->getJson(route('admin.products.edit', $product))
            ->assertOk()
            ->assertJsonPath('product.id', $product->id);
    }

    // -------------------------------------------------------
    // Update
    // -------------------------------------------------------

    public function test_product_can_be_updated(): void
    {
        $this->authenticatedUser();
        $product = Product::factory()->create(['name' => 'Old Name']);

        $this->putJson(route('admin.products.update', $product), [
            'name' => 'New Name',
            'price' => 15.00,
            'is_active' => false,
        ])->assertOk()
            ->assertJson(['success' => true]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'New Name',
            'is_active' => false,
        ]);
    }

    public function test_product_image_is_replaced_on_update(): void
    {
        $this->authenticatedUser();
        Storage::fake('public');

        $product = Product::factory()->create([
            'image' => 'products/old.jpg',
        ]);

        Storage::disk('public')->put('products/old.jpg', 'old-content');

        $this->putJson(route('admin.products.update', $product), [
            'name' => $product->name,
            'price' => $product->price,
            'is_active' => true,
            'image' => UploadedFile::fake()->image('new.jpg'),
        ])->assertOk();

        Storage::disk('public')->assertMissing('products/old.jpg');
        Storage::disk('public')->assertExists($product->fresh()->image);
    }

    public function test_product_image_is_kept_when_not_replaced(): void
    {
        $this->authenticatedUser();
        $product = Product::factory()->create(['image' => 'products/keep.jpg']);

        $this->putJson(route('admin.products.update', $product), [
            'name' => 'Updated',
            'price' => 10,
            'is_active' => true,
        ])->assertOk();

        $this->assertEquals('products/keep.jpg', $product->fresh()->image);
    }

    // -------------------------------------------------------
    // Destroy (Soft Delete)
    // -------------------------------------------------------

    public function test_product_can_be_soft_deleted(): void
    {
        $this->authenticatedUser();
        $product = Product::factory()->create();

        $this->deleteJson(route('admin.products.destroy', $product))
            ->assertOk()
            ->assertJson(['success' => true]);

        $this->assertSoftDeleted('products', ['id' => $product->id]);
    }
}
