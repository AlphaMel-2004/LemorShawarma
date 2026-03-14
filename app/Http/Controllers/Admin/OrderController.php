<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Display the order logs page.
     */
    public function index(): View
    {
        $orders = Order::with('items')
            ->latest()
            ->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }
}
