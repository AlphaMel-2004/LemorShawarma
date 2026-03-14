<?php

namespace Tests\Feature\Admin;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    // ── Access Control ──

    public function test_guest_cannot_access_orders_page(): void
    {
        $response = $this->get('/admin/orders');

        $response->assertRedirect('/admin/login');
    }

    public function test_authenticated_user_can_view_orders_page(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/orders');

        $response->assertStatus(200);
        $response->assertViewIs('admin.orders.index');
    }

    // ── Orders Display ──

    public function test_orders_page_shows_empty_state_when_no_orders(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/orders');

        $response->assertStatus(200);
        $response->assertSee('No orders yet');
    }

    public function test_orders_page_displays_order_data(): void
    {
        $order = Order::factory()->create([
            'order_number' => 'PQ-260308-TEST1',
            'total_amount' => 350.00,
            'status' => 'pending',
        ]);

        OrderItem::factory()->create([
            'order_id' => $order->id,
            'product_name' => 'Shawarma Wrap',
            'quantity' => 2,
            'unit_price' => 125.00,
            'subtotal' => 250.00,
        ]);

        OrderItem::factory()->create([
            'order_id' => $order->id,
            'product_name' => 'Falafel Plate',
            'quantity' => 1,
            'unit_price' => 100.00,
            'subtotal' => 100.00,
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/orders');

        $response->assertStatus(200);
        $response->assertSee('PQ-260308-TEST1');
        $response->assertSee('350.00');
        $response->assertSee('Shawarma Wrap');
        $response->assertSee('Falafel Plate');
        $response->assertSee('2 items');
    }

    public function test_orders_are_displayed_in_latest_first_order(): void
    {
        $oldOrder = Order::factory()->create([
            'order_number' => 'PQ-260308-OLD01',
            'created_at' => now()->subDay(),
        ]);
        $newOrder = Order::factory()->create([
            'order_number' => 'PQ-260308-NEW01',
            'created_at' => now(),
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/orders');

        $response->assertStatus(200);
        $response->assertSeeInOrder(['PQ-260308-NEW01', 'PQ-260308-OLD01']);
    }

    public function test_orders_page_is_paginated(): void
    {
        Order::factory()->count(20)->create();

        $response = $this->actingAs($this->admin)->get('/admin/orders');

        $response->assertStatus(200);
        $response->assertViewHas('orders');
        $this->assertEquals(15, $response->viewData('orders')->count());
    }
}
