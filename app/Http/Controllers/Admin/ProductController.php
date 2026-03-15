<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|JsonResponse
    {
        $query = Product::query()
            ->select(['id', 'name', 'category', 'description', 'price', 'image', 'is_active', 'created_at']);

        $availableCategories = Product::query()
            ->select('category')
            ->whereNotNull('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search): void {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->input('status') === 'active');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->string('category')->toString());
        }

        $sortField = $request->input('sort', 'created_at');
        $sortDirection = $request->input('direction', 'desc');
        $allowedSorts = ['id', 'name', 'category', 'price', 'is_active', 'created_at'];

        if (in_array($sortField, $allowedSorts)) {
            $query->orderBy($sortField, $sortDirection === 'asc' ? 'asc' : 'desc');
        } else {
            $query->latest();
        }

        $products = $query->paginate(10)->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.products._table', compact('products'))->render(),
                'pagination' => view('admin.products._pagination', compact('products'))->render(),
            ]);
        }

        return view('admin.products.index', compact('products', 'availableCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $this->storeProductImage($request->file('image'));
        }

        $product = Product::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully.',
            'product' => $product,
        ]);
    }

    /**
     * Show the specified resource for editing (AJAX).
     */
    public function edit(Product $product): JsonResponse
    {
        return response()->json([
            'product' => $product,
            'image_url' => $product->image ? Storage::url($product->image) : null,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
                $this->deletePublicMirror($product->image);
            }
            $data['image'] = $this->storeProductImage($request->file('image'));
        } else {
            unset($data['image']);
        }

        $product->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully.',
            'product' => $product->fresh(),
        ]);
    }

    /**
     * Remove the specified resource from storage (soft delete).
     */
    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully.',
        ]);
    }

    private function storeProductImage(?UploadedFile $image): ?string
    {
        if ($image === null) {
            return null;
        }

        $storedPath = $image->store('products', 'public');

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
