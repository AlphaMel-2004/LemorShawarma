@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    {{-- Page Header --}}
    <div class="mb-4">
        <h4 class="fw-bold mb-1" style="color: var(--admin-text);">
            <i class="bi bi-sliders2 me-2" style="color: var(--admin-primary);"></i>Admin Control Panel
        </h4>
        <p class="mb-0" style="color: var(--admin-text-muted); font-size: 0.9rem;">
            Monitor product catalog and store overview
        </p>
    </div>

    {{-- Stats Cards --}}
    <div class="row g-3 mb-4">
        {{-- Total Products --}}
        <div class="col-sm-6 col-xl-3">
            <div class="admin-card p-3 h-100">
                <div class="d-flex align-items-start gap-3">
                    <div class="stat-icon stat-icon-primary">
                        <i class="bi bi-box-seam-fill"></i>
                    </div>
                    <div>
                        <div class="stat-label">Total Products</div>
                        <div class="stat-value">{{ $totalProducts }}</div>
                        <div class="stat-sub">
                            <span style="color: var(--admin-text-muted);">&rarr;</span> Catalog items
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Active Products --}}
        <div class="col-sm-6 col-xl-3">
            <div class="admin-card p-3 h-100">
                <div class="d-flex align-items-start gap-3">
                    <div class="stat-icon stat-icon-success">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div>
                        <div class="stat-label">Active Products</div>
                        <div class="stat-value">{{ $activeProducts }}</div>
                        <div class="stat-sub">
                            <span style="color: var(--admin-text-muted);">&rarr;</span> Currently listed
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Inactive Products --}}
        <div class="col-sm-6 col-xl-3">
            <div class="admin-card p-3 h-100">
                <div class="d-flex align-items-start gap-3">
                    <div class="stat-icon stat-icon-danger">
                        <i class="bi bi-x-circle-fill"></i>
                    </div>
                    <div>
                        <div class="stat-label">Inactive Products</div>
                        <div class="stat-value">{{ $inactiveProducts }}</div>
                        <div class="stat-sub">
                            <span style="color: var(--admin-text-muted);">&rarr;</span> Hidden from menu
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Average Price --}}
        <div class="col-sm-6 col-xl-3">
            <div class="admin-card p-3 h-100">
                <div class="d-flex align-items-start gap-3">
                    <div class="stat-icon stat-icon-warning">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div>
                        <div class="stat-label">Average Price</div>
                        <div class="stat-value">${{ number_format($averagePrice, 2) }}</div>
                        <div class="stat-sub">
                            <span style="color: var(--admin-text-muted);">&rarr;</span> Per product
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content Row --}}
    <div class="row g-3">
        {{-- Recent Products Table --}}
        <div class="col-lg-8">
            <div class="admin-card">
                <div class="d-flex align-items-center justify-content-between p-3" style="border-bottom: 1px solid var(--admin-border);">
                    <h6 class="fw-bold mb-0">
                        <i class="bi bi-clock-history me-2" style="color: var(--admin-primary);"></i>Recent Products
                    </h6>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-light" style="font-size: 0.8rem;">
                        View All <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="table admin-table mb-0">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Added</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentProducts as $product)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            @if($product->image)
                                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="product-thumb">
                                            @else
                                                <div class="product-thumb-placeholder">
                                                    <i class="bi bi-image"></i>
                                                </div>
                                            @endif
                                            <span class="fw-semibold">{{ $product->name }}</span>
                                        </div>
                                    </td>
                                    <td>${{ number_format($product->price, 2) }}</td>
                                    <td>
                                        <span class="badge-status {{ $product->is_active ? 'badge-active' : 'badge-inactive' }}">
                                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td style="color: var(--admin-text-muted); font-size: 0.85rem;">
                                        {{ $product->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.products.index') }}" class="btn-action" title="View in Products">
                                            <i class="bi bi-arrow-right"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <div style="color: var(--admin-text-muted);">
                                            <i class="bi bi-box-seam" style="font-size: 1.5rem;"></i>
                                            <p class="mt-2 mb-0">No products yet.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Sidebar: Price Distribution & Quick Actions --}}
        <div class="col-lg-4">
            {{-- Price Distribution --}}
            <div class="admin-card mb-3">
                <div class="p-3" style="border-bottom: 1px solid var(--admin-border);">
                    <h6 class="fw-bold mb-0">
                        <i class="bi bi-bar-chart-fill me-2" style="color: var(--admin-primary);"></i>Price Distribution
                    </h6>
                </div>
                <div class="p-3">
                    {{-- Budget --}}
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span style="font-size: 0.85rem;">Budget (&lt; $5)</span>
                            <span class="fw-semibold" style="color: var(--admin-success); font-size: 0.85rem;">{{ $priceRanges['budget'] }}</span>
                        </div>
                        <div class="progress" style="height: 6px; background-color: var(--admin-border); border-radius: 3px;">
                            <div class="progress-bar" role="progressbar"
                                 style="width: {{ $totalProducts > 0 ? ($priceRanges['budget'] / $totalProducts) * 100 : 0 }}%; background-color: var(--admin-success); border-radius: 3px;">
                            </div>
                        </div>
                    </div>

                    {{-- Mid-range --}}
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span style="font-size: 0.85rem;">Mid-Range ($5 – $15)</span>
                            <span class="fw-semibold" style="color: var(--admin-primary); font-size: 0.85rem;">{{ $priceRanges['mid'] }}</span>
                        </div>
                        <div class="progress" style="height: 6px; background-color: var(--admin-border); border-radius: 3px;">
                            <div class="progress-bar" role="progressbar"
                                 style="width: {{ $totalProducts > 0 ? ($priceRanges['mid'] / $totalProducts) * 100 : 0 }}%; background-color: var(--admin-primary); border-radius: 3px;">
                            </div>
                        </div>
                    </div>

                    {{-- Premium --}}
                    <div>
                        <div class="d-flex justify-content-between mb-1">
                            <span style="font-size: 0.85rem;">Premium (&gt; $15)</span>
                            <span class="fw-semibold" style="color: var(--admin-warning); font-size: 0.85rem;">{{ $priceRanges['premium'] }}</span>
                        </div>
                        <div class="progress" style="height: 6px; background-color: var(--admin-border); border-radius: 3px;">
                            <div class="progress-bar" role="progressbar"
                                 style="width: {{ $totalProducts > 0 ? ($priceRanges['premium'] / $totalProducts) * 100 : 0 }}%; background-color: var(--admin-warning); border-radius: 3px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="admin-card">
                <div class="p-3" style="border-bottom: 1px solid var(--admin-border);">
                    <h6 class="fw-bold mb-0">
                        <i class="bi bi-lightning-fill me-2" style="color: var(--admin-warning);"></i>Quick Actions
                    </h6>
                </div>
                <div class="p-3 d-grid gap-2">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-admin-primary btn-sm">
                        <i class="bi bi-box-seam me-1"></i> Manage Products
                    </a>
                    <a href="{{ route('home') }}" target="_blank" class="btn btn-sm btn-outline-light">
                        <i class="bi bi-eye me-1"></i> Preview Store
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        flex-shrink: 0;
    }

    .stat-icon-primary {
        background-color: rgba(99, 102, 241, 0.15);
        color: var(--admin-primary);
    }

    .stat-icon-success {
        background-color: rgba(34, 197, 94, 0.15);
        color: var(--admin-success);
    }

    .stat-icon-danger {
        background-color: rgba(239, 68, 68, 0.15);
        color: var(--admin-danger);
    }

    .stat-icon-warning {
        background-color: rgba(245, 158, 11, 0.15);
        color: var(--admin-warning);
    }

    .stat-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--admin-text-muted);
        font-weight: 600;
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 800;
        line-height: 1.2;
        margin-top: 0.15rem;
    }

    .stat-sub {
        font-size: 0.75rem;
        color: var(--admin-text-muted);
        margin-top: 0.15rem;
    }
</style>
@endpush
