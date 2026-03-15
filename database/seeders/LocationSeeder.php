<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            [
                'name' => 'Downtown Flagship',
                'address' => '123 Golden Avenue, Downtown District',
                'phone' => '+1 (555) 123-4567',
                'hours' => 'Mon-Sun: 11AM - 11PM',
                'image' => null,
                'latitude' => 14.599512,
                'longitude' => 120.984222,
                'is_active' => true,
            ],
            [
                'name' => 'Westside Plaza',
                'address' => '456 Sunset Boulevard, Westside',
                'phone' => '+1 (555) 234-5678',
                'hours' => 'Mon-Sun: 10AM - 10PM',
                'image' => null,
                'latitude' => 14.554729,
                'longitude' => 121.024445,
                'is_active' => true,
            ],
            [
                'name' => 'Harbor View',
                'address' => '789 Marina Drive, Harbor District',
                'phone' => '+1 (555) 345-6789',
                'hours' => 'Mon-Sun: 11AM - 12AM',
                'image' => null,
                'latitude' => 14.531139,
                'longitude' => 120.981667,
                'is_active' => true,
            ],
        ];

        foreach ($locations as $location) {
            Location::updateOrCreate(
                ['name' => $location['name']],
                $location,
            );
        }
    }
}
