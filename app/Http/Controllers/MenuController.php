<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class MenuController extends Controller
{
    /**
     * Display the full menu page with all active products.
     */
    public function index(): View
    {
        $products = Product::query()
            ->select(['id', 'name', 'description', 'price', 'image'])
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('menu', compact('products'));
    }
}
