<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Location;
use App\Models\Product;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(): View
    {
        $productSnapshot = Product::query()
            ->selectRaw(
                'COUNT(*) as total_products,
                COALESCE(SUM(CASE WHEN is_active = 1 THEN 1 ELSE 0 END), 0) as active_products,
                COALESCE(SUM(CASE WHEN is_active = 0 THEN 1 ELSE 0 END), 0) as inactive_products,
                COALESCE(AVG(price), 0) as average_price,
                COALESCE(MAX(price), 0) as highest_price,
                COALESCE(MIN(CASE WHEN is_active = 1 THEN price END), 0) as lowest_active_price'
            )
            ->first();

        $totalProducts = (int) ($productSnapshot->total_products ?? 0);
        $activeProducts = (int) ($productSnapshot->active_products ?? 0);
        $inactiveProducts = (int) ($productSnapshot->inactive_products ?? 0);
        $averagePrice = (float) ($productSnapshot->average_price ?? 0);
        $highestPrice = (float) ($productSnapshot->highest_price ?? 0);
        $lowestPrice = (float) ($productSnapshot->lowest_active_price ?? 0);
        $activeProductsRate = $totalProducts > 0
            ? (int) round(($activeProducts / $totalProducts) * 100)
            : 0;

        $locationSnapshot = Location::query()
            ->selectRaw(
                'COUNT(*) as total_locations,
                COALESCE(SUM(CASE WHEN is_active = 1 THEN 1 ELSE 0 END), 0) as active_locations,
                COALESCE(SUM(CASE WHEN is_active = 0 THEN 1 ELSE 0 END), 0) as inactive_locations'
            )
            ->first();

        $totalLocations = (int) ($locationSnapshot->total_locations ?? 0);
        $activeLocations = (int) ($locationSnapshot->active_locations ?? 0);
        $inactiveLocations = (int) ($locationSnapshot->inactive_locations ?? 0);

        $feedbackSnapshot = Feedback::query()
            ->selectRaw(
                'COUNT(*) as total_feedback,
                COALESCE(SUM(CASE WHEN is_visible = 1 THEN 1 ELSE 0 END), 0) as visible_feedback,
                COALESCE(SUM(CASE WHEN is_visible = 0 THEN 1 ELSE 0 END), 0) as hidden_feedback,
                COALESCE(AVG(rating), 0) as average_rating'
            )
            ->first();

        $totalFeedback = (int) ($feedbackSnapshot->total_feedback ?? 0);
        $visibleFeedback = (int) ($feedbackSnapshot->visible_feedback ?? 0);
        $hiddenFeedback = (int) ($feedbackSnapshot->hidden_feedback ?? 0);
        $averageRating = (float) ($feedbackSnapshot->average_rating ?? 0);

        $recentProducts = Product::query()
            ->select(['id', 'name', 'price', 'image', 'is_active', 'created_at'])
            ->latest()
            ->limit(5)
            ->get();

        $recentFeedback = Feedback::query()
            ->select(['id', 'customer_name', 'rating', 'message', 'is_visible', 'created_at'])
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'activeProducts',
            'inactiveProducts',
            'averagePrice',
            'highestPrice',
            'lowestPrice',
            'activeProductsRate',
            'totalLocations',
            'activeLocations',
            'inactiveLocations',
            'totalFeedback',
            'visibleFeedback',
            'hiddenFeedback',
            'averageRating',
            'recentProducts',
            'recentFeedback',
        ));
    }
}
