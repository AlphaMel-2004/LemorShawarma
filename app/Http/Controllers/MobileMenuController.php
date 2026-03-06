<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFeedbackRequest;
use App\Models\Feedback;
use App\Models\Product;
use App\Models\SiteSetting;
use Illuminate\Http\JsonResponse;
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
}
