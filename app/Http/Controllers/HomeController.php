<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the homepage.
     */
    public function index(): View
    {
        $menuItems = $this->getMenuItems();
        $testimonials = $this->getTestimonials();
        $locations = $this->getLocations();

        return view('home', compact('menuItems', 'testimonials', 'locations'));
    }

    /**
     * Get menu items data.
     */
    private function getMenuItems(): array
    {
        return [
            [
                'id' => 1,
                'name' => 'Classic Chicken Shawarma',
                'description' => 'Tender marinated chicken wrapped in warm pita with fresh vegetables and our signature garlic sauce.',
                'price' => 12.99,
                'category' => 'signature',
                'image' => 'https://images.unsplash.com/photo-1529006557810-274b9b2fc783?w=400',
                'badge' => 'Best Seller',
            ],
            [
                'id' => 2,
                'name' => 'Royal Beef Shawarma',
                'description' => 'Premium beef slices slow-roasted to perfection with Mediterranean spices and tahini sauce.',
                'price' => 14.99,
                'category' => 'signature',
                'image' => 'https://images.unsplash.com/photo-1561651823-34feb02250e4?w=400',
                'badge' => 'Premium',
            ],
            [
                'id' => 3,
                'name' => 'Mixed Grill Platter',
                'description' => 'A luxurious combination of chicken and beef shawarma served with rice, hummus, and grilled vegetables.',
                'price' => 24.99,
                'category' => 'platters',
                'image' => 'https://images.unsplash.com/photo-1544025162-d76694265947?w=400',
                'badge' => 'Chef\'s Choice',
            ],
            [
                'id' => 4,
                'name' => 'Falafel Wrap',
                'description' => 'Crispy golden falafel with fresh salad, pickles, and creamy tahini in a soft wrap.',
                'price' => 10.99,
                'category' => 'wraps',
                'image' => 'https://images.unsplash.com/photo-1593001874117-c99c800e3eb6?w=400',
                'badge' => null,
            ],
            [
                'id' => 5,
                'name' => 'Shawarma Bowl',
                'description' => 'Deconstructed shawarma over fragrant rice with all the fixings and house-made sauces.',
                'price' => 16.99,
                'category' => 'bowls',
                'image' => 'https://images.unsplash.com/photo-1512058564366-18510be2db19?w=400',
                'badge' => 'Healthy',
            ],
            [
                'id' => 6,
                'name' => 'Lamb Kofta Plate',
                'description' => 'Seasoned ground lamb skewers grilled over open flame, served with aromatic rice.',
                'price' => 18.99,
                'category' => 'platters',
                'image' => 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=400',
                'badge' => null,
            ],
            [
                'id' => 7,
                'name' => 'Veggie Delight Wrap',
                'description' => 'Grilled vegetables with halloumi cheese, fresh herbs, and zesty lemon dressing.',
                'price' => 11.99,
                'category' => 'wraps',
                'image' => 'https://images.unsplash.com/photo-1540914124281-342587941389?w=400',
                'badge' => 'Vegetarian',
            ],
            [
                'id' => 8,
                'name' => 'Mediterranean Bowl',
                'description' => 'Fresh quinoa base with grilled chicken, cherry tomatoes, cucumber, olives, and feta.',
                'price' => 15.99,
                'category' => 'bowls',
                'image' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=400',
                'badge' => null,
            ],
        ];
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
