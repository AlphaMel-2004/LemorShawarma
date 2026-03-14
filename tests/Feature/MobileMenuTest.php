<?php

namespace Tests\Feature;

use App\Models\Feedback;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MobileMenuTest extends TestCase
{
    use RefreshDatabase;

    // ── Menu Page ──

    public function test_mobile_menu_page_loads_successfully(): void
    {
        $response = $this->get(route('mobile.menu'));

        $response->assertStatus(200);
        $response->assertSee('Pita Queen');
    }

    public function test_mobile_menu_displays_active_products(): void
    {
        $active = Product::factory()->create(['is_active' => true, 'name' => 'Shawarma Wrap']);
        $inactive = Product::factory()->create(['is_active' => false, 'name' => 'Hidden Item']);

        $response = $this->get(route('mobile.menu'));

        $response->assertStatus(200);
        $response->assertSee('Shawarma Wrap');
        $response->assertDontSee('Hidden Item');
    }

    public function test_mobile_menu_shows_empty_state_when_no_products(): void
    {
        $response = $this->get(route('mobile.menu'));

        $response->assertStatus(200);
        $response->assertSee('No menu items available yet');
    }

    public function test_mobile_menu_displays_contact_information(): void
    {
        $response = $this->get(route('mobile.menu'));

        $response->assertStatus(200);
        $response->assertSee('Share Your');
    }

    // ── Feedback Submission ──

    public function test_customer_can_submit_feedback(): void
    {
        $data = [
            'customer_name' => 'John Doe',
            'customer_email' => 'john@example.com',
            'rating' => 5,
            'message' => 'Excellent food and amazing service!',
        ];

        $response = $this->postJson(route('mobile.feedback'), $data);

        $response->assertStatus(201);
        $response->assertJsonFragment(['message' => 'Thank you for your feedback!']);
        $this->assertDatabaseHas('feedback', [
            'customer_name' => 'John Doe',
            'customer_email' => 'john@example.com',
            'rating' => 5,
        ]);
    }

    public function test_feedback_email_is_optional(): void
    {
        $data = [
            'customer_name' => 'Jane Doe',
            'rating' => 4,
            'message' => 'Great pita bread!',
        ];

        $response = $this->postJson(route('mobile.feedback'), $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('feedback', [
            'customer_name' => 'Jane Doe',
            'customer_email' => null,
            'rating' => 4,
        ]);
    }

    public function test_feedback_requires_customer_name(): void
    {
        $data = [
            'rating' => 5,
            'message' => 'Good food.',
        ];

        $response = $this->postJson(route('mobile.feedback'), $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('customer_name');
    }

    public function test_feedback_requires_rating(): void
    {
        $data = [
            'customer_name' => 'John',
            'message' => 'Nice place.',
        ];

        $response = $this->postJson(route('mobile.feedback'), $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('rating');
    }

    public function test_feedback_requires_message(): void
    {
        $data = [
            'customer_name' => 'John',
            'rating' => 5,
        ];

        $response = $this->postJson(route('mobile.feedback'), $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('message');
    }

    public function test_feedback_rating_must_be_between_1_and_5(): void
    {
        $data = [
            'customer_name' => 'John',
            'rating' => 6,
            'message' => 'Great!',
        ];

        $response = $this->postJson(route('mobile.feedback'), $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('rating');

        $data['rating'] = 0;
        $response = $this->postJson(route('mobile.feedback'), $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('rating');
    }

    public function test_feedback_email_must_be_valid(): void
    {
        $data = [
            'customer_name' => 'John',
            'customer_email' => 'not-an-email',
            'rating' => 5,
            'message' => 'Good food!',
        ];

        $response = $this->postJson(route('mobile.feedback'), $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('customer_email');
    }

    public function test_feedback_message_max_length(): void
    {
        $data = [
            'customer_name' => 'John',
            'rating' => 5,
            'message' => str_repeat('a', 2001),
        ];

        $response = $this->postJson(route('mobile.feedback'), $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('message');
    }

    public function test_feedback_is_stored_in_database(): void
    {
        $this->assertDatabaseCount('feedback', 0);

        $this->postJson(route('mobile.feedback'), [
            'customer_name' => 'Ahmed',
            'customer_email' => 'ahmed@example.com',
            'rating' => 3,
            'message' => 'Average experience.',
        ]);

        $this->assertDatabaseCount('feedback', 1);

        $feedback = Feedback::first();
        $this->assertEquals('Ahmed', $feedback->customer_name);
        $this->assertEquals(3, $feedback->rating);
    }

    // ── Place Order ──

    public function test_order_can_be_placed_successfully(): void
    {
        $data = [
            'items' => [
                ['name' => 'Shawarma Wrap', 'quantity' => 2, 'price' => 125.00],
                ['name' => 'Falafel Plate', 'quantity' => 1, 'price' => 100.00],
            ],
        ];

        $response = $this->postJson(route('mobile.order'), $data);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'message',
            'order' => [
                'order_number',
                'total_amount',
                'items',
            ],
        ]);

        $this->assertDatabaseCount('orders', 1);
        $this->assertDatabaseCount('order_items', 2);

        $order = Order::first();
        $this->assertEquals(350.00, $order->total_amount);
        $this->assertStringStartsWith('PQ-', $order->order_number);
    }

    public function test_order_requires_at_least_one_item(): void
    {
        $response = $this->postJson(route('mobile.order'), [
            'items' => [],
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('items');
    }

    public function test_order_items_require_name_quantity_and_price(): void
    {
        $response = $this->postJson(route('mobile.order'), [
            'items' => [
                ['price' => 100],
            ],
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['items.0.name', 'items.0.quantity']);
    }

    public function test_order_quantity_must_be_at_least_one(): void
    {
        $response = $this->postJson(route('mobile.order'), [
            'items' => [
                ['name' => 'Test', 'quantity' => 0, 'price' => 100],
            ],
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('items.0.quantity');
    }

    public function test_order_calculates_total_correctly(): void
    {
        $data = [
            'items' => [
                ['name' => 'Item A', 'quantity' => 3, 'price' => 50.00],
                ['name' => 'Item B', 'quantity' => 2, 'price' => 75.00],
            ],
        ];

        $response = $this->postJson(route('mobile.order'), $data);

        $response->assertStatus(201);

        $order = Order::first();
        $this->assertEquals(300.00, $order->total_amount);
    }

    public function test_order_items_are_stored_with_correct_subtotals(): void
    {
        $data = [
            'items' => [
                ['name' => 'Chicken Kebab', 'quantity' => 2, 'price' => 150.00],
            ],
        ];

        $response = $this->postJson(route('mobile.order'), $data);

        $response->assertStatus(201);

        $this->assertDatabaseHas('order_items', [
            'product_name' => 'Chicken Kebab',
            'quantity' => 2,
            'unit_price' => 150.00,
            'subtotal' => 300.00,
        ]);
    }

    public function test_order_returns_order_number_in_response(): void
    {
        $data = [
            'items' => [
                ['name' => 'Test Item', 'quantity' => 1, 'price' => 100.00],
            ],
        ];

        $response = $this->postJson(route('mobile.order'), $data);

        $response->assertStatus(201);
        $response->assertJsonPath('order.order_number', Order::first()->order_number);
    }

    public function test_order_accepts_optional_customer_name(): void
    {
        $data = [
            'items' => [
                ['name' => 'Test Item', 'quantity' => 1, 'price' => 100.00],
            ],
            'customer_name' => 'Ali',
        ];

        $response = $this->postJson(route('mobile.order'), $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('orders', ['customer_name' => 'Ali']);
    }
}
