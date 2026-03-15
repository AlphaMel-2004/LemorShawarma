<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFeedbackRequest;
use App\Models\Feedback;
use App\Models\Location;
use App\Models\Product;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the homepage.
     */
    public function index(): View
    {
        $menuItems = Product::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
        $menuCategories = Product::query()
            ->where('is_active', true)
            ->whereNotNull('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');
        $testimonials = $this->getTestimonials();
        $locations = $this->getLocations();
        $contactSettings = SiteSetting::getContactSettings();

        return view('home', compact('menuItems', 'menuCategories', 'testimonials', 'locations', 'contactSettings'));
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
        return Location::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'address', 'phone', 'hours', 'image', 'latitude', 'longitude'])
            ->map(function (Location $location): array {
                $imageUrl = $location->image
                    ? (str_starts_with($location->image, 'http') ? $location->image : Storage::url($location->image))
                    : 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=400';

                return [
                    'id' => $location->id,
                    'name' => $location->name,
                    'address' => $location->address,
                    'phone' => $location->phone,
                    'hours' => $location->hours,
                    'image' => $imageUrl,
                    'latitude' => $location->latitude,
                    'longitude' => $location->longitude,
                ];
            })
            ->all();
    }
}
