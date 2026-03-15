<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Feedback::query()
            ->select(['id', 'customer_name', 'customer_email', 'rating', 'message', 'is_visible', 'created_at']);

        if ($request->filled('search')) {
            $search = $request->string('search')->toString();

            $query->where(function ($innerQuery) use ($search): void {
                $innerQuery->where('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_email', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            });
        }

        if ($request->filled('rating')) {
            $query->where('rating', (int) $request->input('rating'));
        }

        if ($request->filled('visibility')) {
            $query->where('is_visible', $request->input('visibility') === 'visible');
        }

        $testimonials = $query->latest()->paginate(10)->withQueryString();

        return view('admin.testimonials.index', compact('testimonials'));
    }

    /**
     * Update testimonial visibility.
     */
    public function update(Request $request, Feedback $testimonial): RedirectResponse
    {
        $validated = $request->validate([
            'is_visible' => ['required', 'boolean'],
        ]);

        $testimonial->update([
            'is_visible' => (bool) $validated['is_visible'],
        ]);

        $message = $testimonial->is_visible
            ? 'Testimonial is now visible on the website.'
            : 'Testimonial was hidden from the website.';

        return redirect()->route('admin.testimonials.index', $request->only(['search', 'rating', 'visibility', 'page']))
            ->with('status', $message);
    }

    /**
     * Show the form for creating a new resource.
     */
    /**
     * Remove the specified testimonial from storage.
     */
    public function destroy(Feedback $testimonial): RedirectResponse
    {
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')
            ->with('status', 'Testimonial deleted successfully.');
    }
}
