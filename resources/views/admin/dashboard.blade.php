@extends('layouts.admin')

@section('page-title', 'Dashboard')

@push('styles')
<style>
    .stat-card {
        padding: 1.5rem;
        border-radius: 12px;
        background-color: var(--admin-card);
        border: 1px solid var(--admin-border);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .stat-icon-primary {
        background: rgba(57, 106, 255, 0.12);
        color: var(--admin-primary);
    }

    .stat-icon-success {
        background: rgba(22, 219, 170, 0.12);
        color: var(--admin-success);
    }

    .stat-icon-danger {
        background: rgba(254, 92, 115, 0.12);
        color: var(--admin-danger);
    }

    .stat-icon-warning {
        background: rgba(245, 158, 11, 0.12);
        color: #f59e0b;
    }

    .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--admin-text);
        line-height: 1.2;
    }

    .stat-label {
        font-size: 0.8rem;
        color: var(--admin-text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    .price-stat-card {
        padding: 1.25rem 1.5rem;
        border-radius: 12px;
        background-color: var(--admin-card);
        border: 1px solid var(--admin-border);
    }

    .price-stat-label {
        font-size: 0.75rem;
        color: var(--admin-text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    .price-stat-value {
        font-size: 1.35rem;
        font-weight: 700;
        color: var(--admin-text);
    }

    .recent-product-row {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        padding: 0.85rem 0;
        border-bottom: 1px solid var(--admin-border);
    }

    .recent-product-row:last-child {
        border-bottom: none;
    }

    .recent-product-thumb {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        object-fit: cover;
        border: 1px solid var(--admin-border);
        flex-shrink: 0;
    }

    .recent-product-thumb-placeholder {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        background-color: var(--admin-border);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--admin-text-muted);
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .recent-product-name {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--admin-text);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .recent-product-date {
        font-size: 0.75rem;
        color: var(--admin-text-muted);
    }

    .recent-product-price {
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--admin-text);
        white-space: nowrap;
    }

    .quick-action-btn {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 1.25rem;
        border-radius: 10px;
        border: 1px solid var(--admin-border);
        background: var(--admin-card);
        color: var(--admin-text);
        text-decoration: none;
        transition: all 0.2s ease;
        font-size: 0.9rem;
        font-weight: 600;
    }

    .quick-action-btn:hover {
        border-color: var(--admin-primary);
        color: var(--admin-primary);
        background: rgba(57, 106, 255, 0.04);
        transform: translateY(-1px);
    }

    .quick-action-btn i {
        font-size: 1.2rem;
    }

    .welcome-banner {
        background: linear-gradient(135deg, var(--admin-primary), #6c5ce7);
        border-radius: 14px;
        padding: 2rem 2.5rem;
        color: #fff;
        position: relative;
        overflow: hidden;
    }

    .welcome-banner::after {
        content: '';
        position: absolute;
        right: -40px;
        top: -40px;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.08);
    }

    .welcome-banner::before {
        content: '';
        position: absolute;
        right: 60px;
        bottom: -60px;
        width: 160px;
        height: 160px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.05);
    }

    .welcome-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .welcome-subtitle {
        font-size: 0.9rem;
        opacity: 0.85;
    }

    .section-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--admin-text);
        margin-bottom: 1rem;
    }

    @media (max-width: 767.98px) {
        .welcome-banner {
            padding: 1.5rem;
        }

        .welcome-title {
            font-size: 1.2rem;
        }

        .stat-value {
            font-size: 1.35rem;
        }
    }
</style>
@endpush

@section('content')
    {{-- Welcome Banner --}}
    <div class="welcome-banner mb-4">
        <div class="welcome-title">Welcome back, {{ auth()->user()->name ?? 'Admin' }}!</div>
        <div class="welcome-subtitle">Here's an overview of your Pita Queen product catalog.</div>
    </div>

    {{-- Stat Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="stat-icon stat-icon-primary">
                        <i class="bi bi-box-seam-fill"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $totalProducts }}</div>
                <div class="stat-label">Total Products</div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="stat-icon stat-icon-success">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $activeProducts }}</div>
                <div class="stat-label">Active Products</div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="stat-icon stat-icon-danger">
                        <i class="bi bi-x-circle-fill"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $inactiveProducts }}</div>
                <div class="stat-label">Inactive Products</div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="stat-icon stat-icon-warning">
                        <i class="bi bi-tag-fill"></i>
                    </div>
                </div>
                <div class="stat-value">₱{{ number_format($averagePrice ?? 0, 2) }}</div>
                <div class="stat-label">Average Price</div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        {{-- Price Overview --}}
        <div class="col-lg-4">
            <div class="admin-card p-4 h-100">
                <div class="section-title">Price Overview</div>

                <div class="d-flex flex-column gap-3">
                    <div class="price-stat-card">
                        <div class="price-stat-label">Highest Price</div>
                        <div class="price-stat-value">₱{{ number_format($highestPrice ?? 0, 2) }}</div>
                    </div>

                    <div class="price-stat-card">
                        <div class="price-stat-label">Lowest Active Price</div>
                        <div class="price-stat-value">₱{{ number_format($lowestPrice ?? 0, 2) }}</div>
                    </div>

                    <div class="price-stat-card">
                        <div class="price-stat-label">Average Price</div>
                        <div class="price-stat-value">₱{{ number_format($averagePrice ?? 0, 2) }}</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent Products --}}
        <div class="col-lg-8">
            <div class="admin-card p-4 h-100">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="section-title mb-0">Recent Products</div>
                    <a href="{{ route('admin.products.index') }}" class="text-decoration-none" style="font-size: 0.85rem; font-weight: 600; color: var(--admin-primary);">
                        View All <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

                @forelse ($recentProducts as $product)
                    <div class="recent-product-row">
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="recent-product-thumb">
                        @else
                            <div class="recent-product-thumb-placeholder">
                                <i class="bi bi-image"></i>
                            </div>
                        @endif

                        <div class="flex-grow-1 min-width-0">
                            <div class="recent-product-name">{{ $product->name }}</div>
                            <div class="recent-product-date">{{ $product->created_at->format('M d, Y') }}</div>
                        </div>

                        <span class="badge-status {{ $product->is_active ? 'badge-active' : 'badge-inactive' }}">
                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                        </span>

                        <div class="recent-product-price">₱{{ number_format($product->price, 2) }}</div>
                    </div>
                @empty
                    <div class="text-center py-4">
                        <i class="bi bi-inbox" style="font-size: 2.5rem; color: var(--admin-text-muted);"></i>
                        <p class="mt-2 mb-0" style="color: var(--admin-text-muted); font-size: 0.9rem;">No products yet. Add your first product!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="row g-3">
        <div class="col-12">
            <div class="section-title">Quick Actions</div>
        </div>
        <div class="col-sm-6 col-lg-4">
            <a href="{{ route('admin.products.index') }}" class="quick-action-btn w-100">
                <i class="bi bi-box-seam-fill" style="color: var(--admin-primary);"></i>
                Manage Products
            </a>
        </div>
        <div class="col-sm-6 col-lg-4">
            <a href="{{ route('home') }}" target="_blank" class="quick-action-btn w-100">
                <i class="bi bi-globe2" style="color: var(--admin-success);"></i>
                View Website
            </a>
        </div>
    </div>
@endsection
