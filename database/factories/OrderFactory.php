<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_number' => Order::generateOrderNumber(),
            'total_amount' => fake()->randomFloat(2, 50, 2000),
            'status' => 'pending',
            'customer_name' => fake()->optional()->name(),
        ];
    }
}
