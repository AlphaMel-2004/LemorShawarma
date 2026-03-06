<?php

namespace App\Http\Controllers;

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
     * Get testimonials data.
     */
    private function getTestimonials(): array
    {
        return [
            [
                'id' => 1,
                'name' => 'Sarah Mitchell',
                'role' => 'Food Blogger',
                'content' => 'The best shawarma I\'ve ever tasted! The flavors are authentic and the presentation is absolutely stunning. A must-visit for any food lover.',
                'rating' => 5,
                'avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100',
            ],
            [
                'id' => 2,
                'name' => 'Michael Chen',
                'role' => 'Regular Customer',
                'content' => 'I\'ve been coming here for years and the quality has never dropped. The Royal Beef Shawarma is absolutely divine. Highly recommended!',
                'rating' => 5,
                'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100',
            ],
            [
                'id' => 3,
                'name' => 'Emily Rodriguez',
                'role' => 'Food Critic',
                'content' => 'An elevated dining experience that brings Mediterranean cuisine to new heights. The ambiance matches the exceptional food quality.',
                'rating' => 5,
                'avatar' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=100',
            ],
            [
                'id' => 4,
                'name' => 'David Thompson',
                'role' => 'Chef',
                'content' => 'As a professional chef, I appreciate the attention to detail and authentic spice blends. This is shawarma done right!',
                'rating' => 5,
                'avatar' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100',
            ],
        ];
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
