<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreLocationRequest;
use App\Http\Requests\Admin\UpdateLocationRequest;
use App\Models\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Location::query()
            ->select(['id', 'name', 'address', 'phone', 'hours', 'image', 'latitude', 'longitude', 'is_active', 'created_at']);

        if ($request->filled('search')) {
            $search = $request->string('search')->toString();

            $query->where(function ($innerQuery) use ($search): void {
                $innerQuery->where('name', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->input('status') === 'active');
        }

        $locations = $query->latest()->paginate(10)->withQueryString();

        return view('admin.locations.index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.locations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLocationRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->storeLocationImage($request->file('image'));
        }

        Location::create($data);

        return redirect()->route('admin.locations.index')
            ->with('status', 'Location created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function edit(Location $location): View
    {
        return view('admin.locations.edit', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLocationRequest $request, Location $location): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($location->image) {
                Storage::disk('public')->delete($location->image);
                $this->deletePublicMirror($location->image);
            }

            $data['image'] = $this->storeLocationImage($request->file('image'));
        } else {
            unset($data['image']);
        }

        $location->update($data);

        return redirect()->route('admin.locations.index')
            ->with('status', 'Location updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location): RedirectResponse
    {
        $location->delete();

        return redirect()->route('admin.locations.index')
            ->with('status', 'Location deleted successfully.');
    }

    private function storeLocationImage(?UploadedFile $image): ?string
    {
        if ($image === null) {
            return null;
        }

        $storedPath = $image->store('locations', 'public');

        if (! app()->environment('testing')) {
            $this->mirrorToPublicStorage($storedPath);
        }

        return $storedPath;
    }

    private function mirrorToPublicStorage(string $storedPath): void
    {
        $sourcePath = Storage::disk('public')->path($storedPath);
        $targetPath = public_path('storage/'.ltrim($storedPath, '/'));
        $targetDirectory = dirname($targetPath);

        if (! is_dir($targetDirectory)) {
            mkdir($targetDirectory, 0755, true);
        }

        if (is_file($sourcePath)) {
            copy($sourcePath, $targetPath);
        }
    }

    private function deletePublicMirror(string $storedPath): void
    {
        $targetPath = public_path('storage/'.ltrim($storedPath, '/'));

        if (is_file($targetPath)) {
            unlink($targetPath);
        }
    }
}
