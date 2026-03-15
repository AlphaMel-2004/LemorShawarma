<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Location>
 */
class LocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company().' Branch',
            'address' => fake()->streetAddress().', '.fake()->city(),
            'phone' => fake()->phoneNumber(),
            'hours' => 'Mon-Sun: 10AM - 10PM',
            'image' => null,
            'latitude' => fake()->latitude(14.50, 14.70),
            'longitude' => fake()->longitude(120.90, 121.10),
            'is_active' => true,
        ];
    }
}
