<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFeedbackRequest;
use App\Models\Feedback;
use App\Models\Order;
use App\Models\Product;
use App\Models\SiteSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MobileMenuController extends Controller
{
    /**
     * Display the mobile menu page.
     */
    public function index(): View
    {
        $menuItems = Product::where('is_active', true)->orderBy('name')->get();
        $contactSettings = SiteSetting::getContactSettings();

        return view('mobile.menu', compact('menuItems', 'contactSettings'));
    }

    /**
     * Store customer feedback.
     */
    public function storeFeedback(StoreFeedbackRequest $request): JsonResponse
    {
        Feedback::create($request->validated());

        return response()->json([
            'message' => 'Thank you for your feedback!',
        ], 201);
    }

    /**
     * Store a new order from the mobile menu.
     */
    public function storeOrder(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'items' => ['required', 'array', 'min:1'],
            'items.*.name' => ['required', 'string', 'max:255'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.price' => ['required', 'numeric', 'min:0'],
            'customer_name' => ['nullable', 'string', 'max:255'],
        ]);

        $totalAmount = 0;
        $orderItems = [];

        foreach ($validated['items'] as $item) {
            $subtotal = $item['quantity'] * $item['price'];
            $totalAmount += $subtotal;
            $orderItems[] = [
                'product_name' => $item['name'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
                'subtotal' => $subtotal,
            ];
        }

        $order = Order::create([
            'order_number' => Order::generateOrderNumber(),
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'customer_name' => $validated['customer_name'] ?? null,
        ]);

        $order->items()->createMany($orderItems);
        $order->load('items');

        return response()->json([
            'message' => 'Order placed successfully!',
            'order' => [
                'order_number' => $order->order_number,
                'total_amount' => $order->total_amount,
                'items' => $order->items->map(function ($item) {
                    return [
                        'product_name' => $item->product_name,
                        'quantity' => $item->quantity,
                        'unit_price' => $item->unit_price,
                        'subtotal' => $item->subtotal,
                    ];
                }),
            ],
        ], 201);
    }
}
