<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(): View
    {
        $stats = Product::query()
            ->selectRaw(
                'COUNT(*) as total_products,
                COALESCE(SUM(CASE WHEN is_active = 1 THEN 1 ELSE 0 END), 0) as active_products,
                COALESCE(SUM(CASE WHEN is_active = 0 THEN 1 ELSE 0 END), 0) as inactive_products,
                COALESCE(AVG(price), 0) as average_price,
                COALESCE(MAX(price), 0) as highest_price,
                COALESCE(MIN(CASE WHEN is_active = 1 THEN price END), 0) as lowest_active_price'
            )
            ->first();

        $totalProducts = (int) ($stats->total_products ?? 0);
        $activeProducts = (int) ($stats->active_products ?? 0);
        $inactiveProducts = (int) ($stats->inactive_products ?? 0);
        $averagePrice = (float) ($stats->average_price ?? 0);
        $highestPrice = (float) ($stats->highest_price ?? 0);
        $lowestPrice = (float) ($stats->lowest_active_price ?? 0);

        $recentProducts = Product::query()
            ->select(['id', 'name', 'price', 'image', 'is_active', 'created_at'])
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
            'recentProducts',
        ));
    }
}
