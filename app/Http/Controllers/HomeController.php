<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Product;
use App\Models\SiteSetting;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the homepage.
     */
    public function index(): View
    {
        $menuItems = Product::where('is_active', true)->orderBy('name')->get();
        $testimonials = $this->getTestimonials();
        $locations = $this->getLocations();
        $contactSettings = SiteSetting::getContactSettings();

        return view('home', compact('menuItems', 'testimonials', 'locations', 'contactSettings'));
    }

    /**
     * Get testimonials from submitted feedback.
     *
     * @return list<array{name: string, role: string, content: string, rating: int, avatar: string}>
     */
    private function getTestimonials(): array
    {
        $feedback = Feedback::query()
            ->select(['id', 'customer_name', 'rating', 'message', 'created_at'])
            ->where('rating', '>=', 3)
            ->latest()
            ->limit(10)
            ->get();

        if ($feedback->isEmpty()) {
            return [];
        }

        return $feedback->map(fn (Feedback $item): array => [
            'name' => $item->customer_name,
            'role' => 'Valued Customer',
            'content' => $item->message,
            'rating' => $item->rating,
            'avatar' => $this->generateAvatarUrl($item->customer_name),
        ])->all();
    }

    /**
     * Generate a consistent avatar URL based on the customer name.
     */
    private function generateAvatarUrl(string $name): string
    {
        $encoded = urlencode($name);

        return "https://ui-avatars.com/api/?name={$encoded}&background=d4af37&color=0a0a0a&size=100&bold=true";
    }

    /**
     * Get store locations data.
     */
    private function getLocations(): array
    {
        $branchLocation = SiteSetting::getBranchLocationSettings();

        return [
            [
                'id' => 1,
                'name' => $branchLocation['branch_location_name'],
                'address' => $branchLocation['branch_location_address'],
                'phone' => $branchLocation['branch_location_phone'],
                'hours' => $branchLocation['branch_location_hours'],
                'map_url' => $branchLocation['branch_location_map_url'],
                'image' => $branchLocation['branch_location_image_url'],
            ],
        ];
    }
}
