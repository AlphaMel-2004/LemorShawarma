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
        $totalProducts = Product::count();
        $activeProducts = Product::where('is_active', true)->count();
        $inactiveProducts = Product::where('is_active', false)->count();

        $averagePrice = Product::avg('price');
        $highestPrice = Product::max('price');
        $lowestPrice = Product::where('is_active', true)->min('price');

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
