<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFeedbackRequest;
use App\Models\Feedback;
use App\Models\Product;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
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
     * Store customer feedback from homepage.
     */
    public function storeFeedback(StoreFeedbackRequest $request): RedirectResponse
    {
        Feedback::create($request->validated());

        return redirect()->to(route('home').'#feedback')
            ->with('feedback_success', 'Thank you for sharing your experience!');
    }

    /**
     * Get testimonials data.
     */
    private function getTestimonials(): array
    {
        return Feedback::query()
            ->where('is_visible', true)
            ->latest()
            ->take(12)
            ->get(['id', 'customer_name', 'rating', 'message'])
            ->map(function (Feedback $feedback): array {
                return [
                    'id' => $feedback->id,
                    'name' => $feedback->customer_name,
                    'role' => 'Verified Guest',
                    'content' => $feedback->message,
                    'rating' => $feedback->rating,
                    'initials' => $this->getNameInitials($feedback->customer_name),
                ];
            })
            ->all();
    }

    /**
     * Build a two-letter initials badge from the first two name parts.
     */
    private function getNameInitials(string $name): string
    {
        $nameParts = array_values(array_filter(preg_split('/\s+/', trim($name)) ?: []));

        if ($nameParts === []) {
            return 'GU';
        }

        $firstInitial = Str::substr($nameParts[0], 0, 1);
        $secondInitial = isset($nameParts[1])
            ? Str::substr($nameParts[1], 0, 1)
            : Str::substr($nameParts[0], 1, 1);

        $initials = Str::upper($firstInitial.$secondInitial);

        return $initials !== '' ? $initials : 'GU';
    }

    /**
     * Get store locations data.
     */
    private function getLocations(): array
    {
        return [
            [
                'id' => 1,
                'name' => 'Downtown Flagship',
                'address' => '123 Golden Avenue, Downtown District',
                'phone' => '+1 (555) 123-4567',
                'hours' => 'Mon-Sun: 11AM - 11PM',
                'image' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=400',
            ],
            [
                'id' => 2,
                'name' => 'Westside Plaza',
                'address' => '456 Sunset Boulevard, Westside',
                'phone' => '+1 (555) 234-5678',
                'hours' => 'Mon-Sun: 10AM - 10PM',
                'image' => 'https://images.unsplash.com/photo-1552566626-52f8b828add9?w=400',
            ],
            [
                'id' => 3,
                'name' => 'Harbor View',
                'address' => '789 Marina Drive, Harbor District',
                'phone' => '+1 (555) 345-6789',
                'hours' => 'Mon-Sun: 11AM - 12AM',
                'image' => 'https://images.unsplash.com/photo-1537047902294-62a40c20a6ae?w=400',
            ],
        ];
    }
}
