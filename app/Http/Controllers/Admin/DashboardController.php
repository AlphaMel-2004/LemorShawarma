<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalProducts = Product::count();
        $activeProducts = Product::where('is_active', true)->count();
        $inactiveProducts = Product::where('is_active', false)->count();
        $averagePrice = Product::avg('price') ?? 0;

        $recentProducts = Product::query()
            ->select(['id', 'name', 'price', 'is_active', 'image', 'created_at'])
            ->latest()
            ->limit(5)
            ->get();

        $priceRanges = [
            'budget' => Product::where('price', '<', 5)->count(),
            'mid' => Product::whereBetween('price', [5, 15])->count(),
            'premium' => Product::where('price', '>', 15)->count(),
        ];

        return view('admin.dashboard', compact(
            'totalProducts',
            'activeProducts',
            'inactiveProducts',
            'averagePrice',
            'recentProducts',
            'priceRanges',
        ));
    }
}
