@extends('layouts.admin')

@section('page-title', 'Dashboard')

@push('styles')
<style>
    .dashboard-shell {
        display: flex;
        flex-direction: column;
        gap: 1.35rem;
        max-width: 1280px;
        margin: 0 auto;
    }

    .dashboard-hero {
        position: relative;
        overflow: hidden;
        padding: 1.85rem;
        border-radius: 20px;
        background: linear-gradient(120deg, #171717 0%, #101010 45%, #1a1500 100%);
        color: #fff;
        border: 1px solid rgba(212, 175, 55, 0.28);
        box-shadow: 0 28px 54px rgba(0, 0, 0, 0.45);
    }

    .dashboard-hero::selection {
        background: rgba(255, 255, 255, 0.35);
    }

    .dashboard-hero::before,
    .dashboard-hero::after {
        content: '';
        position: absolute;
        border-radius: 999px;
        background: rgba(212, 175, 55, 0.14);
        pointer-events: none;
        animation: floatOrb 7s ease-in-out infinite;
    }

    .dashboard-hero::before {
        width: 260px;
        height: 260px;
        right: -90px;
        top: -100px;
    }

    .dashboard-hero::after {
        width: 180px;
        height: 180px;
        right: 110px;
        bottom: -95px;
        animation-delay: 0.9s;
    }

    .dashboard-hero-glow {
        position: absolute;
        inset: 0;
        background:
            linear-gradient(100deg, rgba(212, 175, 55, 0.12), rgba(255, 255, 255, 0)),
            linear-gradient(108deg, rgba(9, 9, 9, 0.24) 0%, rgba(9, 9, 9, 0.5) 100%),
            url('{{ asset('images/lemorfood1.png') }}') center/cover no-repeat;
        opacity: 0.42;
        pointer-events: none;
    }

    .dashboard-hero-shine {
        position: absolute;
        width: 42%;
        height: 220%;
        left: -18%;
        top: -58%;
        transform: rotate(16deg);
        background: linear-gradient(180deg, rgba(212, 175, 55, 0.16), rgba(255, 255, 255, 0));
        pointer-events: none;
    }

    .dashboard-hero-body {
        position: relative;
        z-index: 1;
    }

    .dashboard-hero h2 {
        margin: 0;
        font-size: 1.8rem;
        font-weight: 800;
        letter-spacing: -0.02em;
    }

    .dashboard-hero p {
        margin: 0.45rem 0 0;
        max-width: 640px;
        font-size: 1rem;
        color: rgba(255, 255, 255, 0.88);
    }

    .hero-pills {
        display: flex;
        flex-wrap: wrap;
        gap: 0.55rem;
        margin-top: 1rem;
    }

    .hero-pill {
        border: 1px solid rgba(212, 175, 55, 0.34);
        border-radius: 999px;
        padding: 0.3rem 0.7rem;
        font-size: 0.79rem;
        color: rgba(255, 243, 211, 0.94);
        background: rgba(212, 175, 55, 0.14);
    }

    .hero-actions {
        margin-top: 1rem;
        display: flex;
        flex-wrap: wrap;
        gap: 0.55rem;
    }

    .hero-action-btn {
        border-radius: 999px;
        border: 1px solid rgba(212, 175, 55, 0.32);
        color: #fbe8b2;
        background: rgba(212, 175, 55, 0.14);
        font-size: 0.82rem;
        font-weight: 700;
        padding: 0.46rem 0.95rem;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .hero-action-btn:hover {
        color: #fff5d9;
        background: rgba(212, 175, 55, 0.24);
        transform: translateY(-1px);
    }

    .metric-card {
        position: relative;
        overflow: hidden;
        padding: 1.18rem;
        border-radius: 16px;
        border: 1px solid var(--admin-border);
        background: linear-gradient(180deg, #1f1f1f 0%, #191919 100%);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        box-shadow: 0 14px 28px rgba(0, 0, 0, 0.4);
    }

    .metric-card::after {
        content: '';
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        height: 3px;
        background: linear-gradient(90deg, rgba(212, 175, 55, 0.4), rgba(212, 175, 55, 0));
    }

    .metric-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 14px 30px rgba(0, 0, 0, 0.48);
    }

    .metric-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
    }

    .metric-icon {
        width: 42px;
        height: 42px;
        border-radius: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }

    .metric-icon-blue {
        background: rgba(212, 175, 55, 0.16);
        color: var(--admin-primary);
    }

    .metric-icon-green {
        background: rgba(22, 219, 170, 0.15);
        color: var(--admin-success);
    }

    .metric-icon-coral {
        background: rgba(254, 92, 115, 0.15);
        color: var(--admin-danger);
    }

    .metric-icon-amber {
        background: rgba(245, 158, 11, 0.16);
        color: #d97706;
    }

    .metric-label {
        margin: 0.85rem 0 0.22rem;
        font-size: 0.78rem;
        color: var(--admin-text-muted);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }

    .metric-value {
        margin: 0;
        font-size: 1.75rem;
        font-weight: 800;
        line-height: 1.15;
        color: var(--admin-text);
        letter-spacing: -0.01em;
    }

    .metric-meta {
        margin: 0.4rem 0 0;
        font-size: 0.8rem;
        color: var(--admin-text-muted);
    }

    .surface-panel {
        border: 1px solid var(--admin-border);
        border-radius: 16px;
        background: linear-gradient(180deg, #1c1c1c 0%, #171717 100%);
        padding: 1.15rem;
        box-shadow: 0 16px 30px rgba(0, 0, 0, 0.42);
    }

    .panel-title {
        margin: 0;
        font-size: 1.02rem;
        font-weight: 700;
        color: var(--admin-text);
    }

    .panel-subtitle {
        margin: 0.18rem 0 0;
        font-size: 0.8rem;
        color: var(--admin-text-muted);
    }

    .insight-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 0.7rem;
        margin-bottom: 0.75rem;
    }

    .insight-row:last-child {
        margin-bottom: 0;
    }

    .insight-title {
        font-size: 0.85rem;
        color: var(--admin-text-muted);
        margin: 0;
    }

    .insight-value {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--admin-text);
        margin: 0;
    }

    .progress-track {
        width: 100%;
        height: 9px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.1);
        overflow: hidden;
        margin-top: 0.45rem;
    }

    .progress-fill {
        height: 100%;
        border-radius: inherit;
    }

    .progress-blue { background: linear-gradient(90deg, #b8942f, #e5c158); }
    .progress-green { background: linear-gradient(90deg, #16dbaa, #5ce3c4); }
    .progress-coral { background: linear-gradient(90deg, #fe5c73, #ff9a8b); }

    .activity-list {
        display: flex;
        flex-direction: column;
        gap: 0.68rem;
        margin-top: 0.75rem;
    }

    .activity-item {
        display: flex;
        align-items: center;
        gap: 0.7rem;
        border: 1px solid var(--admin-border);
        border-radius: 14px;
        padding: 0.72rem;
        background: linear-gradient(180deg, #202020 0%, #191919 100%);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .activity-item:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.42);
    }

    .activity-thumb,
    .activity-avatar {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        flex-shrink: 0;
        border: 1px solid var(--admin-border);
        object-fit: cover;
    }

    .activity-avatar {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.83rem;
        font-weight: 700;
        color: var(--admin-primary);
        background: rgba(212, 175, 55, 0.14);
    }

    .activity-title {
        margin: 0;
        font-size: 0.87rem;
        font-weight: 600;
        color: var(--admin-text);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .activity-meta {
        margin: 0.12rem 0 0;
        font-size: 0.75rem;
        color: var(--admin-text-muted);
    }

    .activity-side {
        margin-left: auto;
        text-align: right;
        white-space: nowrap;
    }

    .activity-price {
        margin: 0;
        font-size: 0.88rem;
        font-weight: 700;
        color: var(--admin-text);
    }

    .activity-snippet {
        margin: 0;
        font-size: 0.75rem;
        color: var(--admin-text-muted);
        max-width: 180px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .rating-stars {
        color: #f59e0b;
        font-size: 0.74rem;
        letter-spacing: 0.03em;
    }

    .quick-grid {
        display: grid;
        gap: 0.85rem;
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }

    .quick-link {
        display: flex;
        align-items: flex-start;
        gap: 0.72rem;
        padding: 0.86rem 0.95rem;
        border-radius: 13px;
        border: 1px solid var(--admin-border);
        color: var(--admin-text);
        text-decoration: none;
        background: linear-gradient(180deg, #202020 0%, #1a1a1a 100%);
        transition: all 0.2s ease;
        font-size: 0.84rem;
        font-weight: 600;
    }

    .quick-link:hover {
        color: var(--admin-primary);
        border-color: rgba(212, 175, 55, 0.38);
        background: rgba(212, 175, 55, 0.08);
        transform: translateY(-1px);
    }

    .quick-link i {
        font-size: 1.05rem;
    }

    .quick-link-icon {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border: 1px solid rgba(212, 175, 55, 0.24);
        background: rgba(212, 175, 55, 0.12);
    }

    .quick-link-title {
        display: block;
        font-weight: 700;
        color: var(--admin-text);
        margin-bottom: 0.14rem;
    }

    .quick-link-sub {
        display: block;
        color: var(--admin-text-muted);
        font-size: 0.74rem;
        line-height: 1.35;
    }

    .panel-action-btn {
        border-radius: 999px;
        font-weight: 700;
        border-color: rgba(212, 175, 55, 0.34);
        color: var(--admin-primary);
        background: rgba(212, 175, 55, 0.08);
    }

    .panel-action-btn:hover {
        color: var(--admin-primary);
        border-color: var(--admin-primary);
        background: rgba(212, 175, 55, 0.18);
    }

    @media (max-width: 991.98px) {
        .dashboard-shell {
            gap: 0.85rem;
        }

        .dashboard-hero {
            padding: 1.15rem;
        }

        .metric-card {
            min-height: 100%;
        }

        .activity-item {
            align-items: flex-start;
            padding: 0.68rem;
        }

        .activity-side {
            min-width: 96px;
        }

        .quick-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 767.98px) {
        .dashboard-shell {
            gap: 0.9rem;
        }

        .dashboard-hero {
            padding: 1.2rem;
        }

        .dashboard-hero h2 {
            font-size: 1.35rem;
        }

        .dashboard-hero p {
            font-size: 0.88rem;
        }

        .hero-pills {
            gap: 0.4rem;
            margin-top: 0.8rem;
        }

        .hero-pill {
            width: 100%;
            text-align: center;
        }

        .hero-actions {
            gap: 0.45rem;
        }

        .hero-action-btn {
            width: 100%;
            text-align: center;
            font-size: 0.79rem;
            padding: 0.46rem 0.75rem;
        }

        .metric-value {
            font-size: 1.42rem;
        }

        .surface-panel {
            padding: 0.9rem;
        }

        .panel-title {
            font-size: 0.93rem;
        }

        .panel-subtitle {
            font-size: 0.78rem;
        }

        .activity-item {
            display: grid;
            grid-template-columns: 40px 1fr;
            gap: 0.55rem 0.6rem;
        }

        .activity-side {
            grid-column: 1 / -1;
            margin-left: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            border-top: 1px dashed var(--admin-border);
            padding-top: 0.45rem;
        }

        .activity-title {
            white-space: normal;
            line-height: 1.25;
        }

        .activity-meta,
        .activity-snippet {
            white-space: normal;
            max-width: none;
        }

        .activity-snippet {
            text-align: right;
        }

        .panel-action-btn {
            font-size: 0.73rem;
            padding-inline: 0.58rem;
        }
    }

    @media (max-width: 575.98px) {
        .dashboard-shell {
            gap: 0.75rem;
        }

        .dashboard-hero {
            border-radius: 14px;
            padding: 1rem;
        }

        .dashboard-hero h2 {
            font-size: 1.1rem;
        }

        .metric-card {
            padding: 0.9rem;
            border-radius: 12px;
        }

        .metric-meta {
            font-size: 0.76rem;
        }

        .quick-link {
            padding: 0.72rem 0.75rem;
            border-radius: 10px;
            font-size: 0.82rem;
        }

        .quick-link-sub {
            font-size: 0.72rem;
        }

        .quick-grid {
            grid-template-columns: 1fr;
        }
    }

    @keyframes floatOrb {
        0%,
        100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }
</style>
@endpush

@section('content')
    <div class="dashboard-shell">
        <section class="dashboard-hero">
            <div class="dashboard-hero-glow"></div>
            <div class="dashboard-hero-shine"></div>
            <div class="dashboard-hero-body">
                <h2 id="dashboardGreetingHeading">
                    <i class="bi bi-sunrise-fill me-2" id="dashboardGreetingIcon"></i>
                    <span id="dashboardGreetingText">Good Morning</span>, {{ auth()->user()->name ?? 'Admin' }}
                </h2>
                <p>Monitor menu health, content visibility, and operations from one streamlined dashboard built for quick daily decisions.</p>

                <div class="hero-pills">
                    <span class="hero-pill">{{ $activeProductsRate }}% products active</span>
                    <span class="hero-pill">{{ $activeLocations }} active locations</span>
                    <span class="hero-pill">{{ number_format($averageRating, 1) }} average rating</span>
                </div>

                <div class="hero-actions">
                    <a href="{{ route('admin.products.index') }}" class="hero-action-btn"><i class="bi bi-plus-circle me-1"></i> Add Product</a>
                    <a href="{{ route('admin.locations.index') }}" class="hero-action-btn"><i class="bi bi-geo-alt me-1"></i> Update Locations</a>
                    <a href="{{ route('admin.testimonials.index') }}" class="hero-action-btn"><i class="bi bi-chat-left-text me-1"></i> Review Feedback</a>
                </div>
            </div>
        </section>

        <section class="row g-4">
            <div class="col-sm-6 col-xl-3">
                <article class="metric-card">
                    <div class="metric-head">
                        <div class="metric-icon metric-icon-blue"><i class="bi bi-box-seam-fill"></i></div>
                    </div>
                    <p class="metric-label">Products</p>
                    <p class="metric-value">{{ $totalProducts }}</p>
                    <p class="metric-meta">{{ $activeProducts }} active • {{ $inactiveProducts }} inactive</p>
                </article>
            </div>

            <div class="col-sm-6 col-xl-3">
                <article class="metric-card">
                    <div class="metric-head">
                        <div class="metric-icon metric-icon-green"><i class="bi bi-geo-alt-fill"></i></div>
                    </div>
                    <p class="metric-label">Locations</p>
                    <p class="metric-value">{{ $totalLocations }}</p>
                    <p class="metric-meta">{{ $activeLocations }} active • {{ $inactiveLocations }} inactive</p>
                </article>
            </div>

            <div class="col-sm-6 col-xl-3">
                <article class="metric-card">
                    <div class="metric-head">
                        <div class="metric-icon metric-icon-coral"><i class="bi bi-chat-left-text-fill"></i></div>
                    </div>
                    <p class="metric-label">Testimonials</p>
                    <p class="metric-value">{{ $totalFeedback }}</p>
                    <p class="metric-meta">{{ $visibleFeedback }} visible • {{ $hiddenFeedback }} hidden</p>
                </article>
            </div>

            <div class="col-sm-6 col-xl-3">
                <article class="metric-card">
                    <div class="metric-head">
                        <div class="metric-icon metric-icon-amber"><i class="bi bi-cash-coin"></i></div>
                    </div>
                    <p class="metric-label">Average Price</p>
                    <p class="metric-value">₱{{ number_format($averagePrice, 2) }}</p>
                    <p class="metric-meta">Highest: ₱{{ number_format($highestPrice, 2) }}</p>
                </article>
            </div>
        </section>

        <section class="row g-4">
            <div class="col-lg-4">
                <article class="surface-panel h-100">
                    <h3 class="panel-title">Performance Snapshot</h3>
                    <p class="panel-subtitle">Live status of your storefront content.</p>

                    <div class="mt-3">
                        <div class="insight-row">
                            <p class="insight-title">Active products</p>
                            <p class="insight-value">{{ $activeProductsRate }}%</p>
                        </div>
                        <div class="progress-track" role="progressbar" aria-label="Active products" aria-valuemin="0" aria-valuemax="100" aria-valuenow="{{ $activeProductsRate }}">
                            <div class="progress-fill progress-blue" style="width: {{ $activeProductsRate }}%;"></div>
                        </div>
                    </div>

                    <div class="mt-3">
                        @php
                            $activeLocationsRate = $totalLocations > 0 ? (int) round(($activeLocations / $totalLocations) * 100) : 0;
                        @endphp
                        <div class="insight-row">
                            <p class="insight-title">Active locations</p>
                            <p class="insight-value">{{ $activeLocationsRate }}%</p>
                        </div>
                        <div class="progress-track" role="progressbar" aria-label="Active locations" aria-valuemin="0" aria-valuemax="100" aria-valuenow="{{ $activeLocationsRate }}">
                            <div class="progress-fill progress-green" style="width: {{ $activeLocationsRate }}%;"></div>
                        </div>
                    </div>

                    <div class="mt-3">
                        @php
                            $visibleTestimonialsRate = $totalFeedback > 0 ? (int) round(($visibleFeedback / $totalFeedback) * 100) : 0;
                        @endphp
                        <div class="insight-row">
                            <p class="insight-title">Visible testimonials</p>
                            <p class="insight-value">{{ $visibleTestimonialsRate }}%</p>
                        </div>
                        <div class="progress-track" role="progressbar" aria-label="Visible testimonials" aria-valuemin="0" aria-valuemax="100" aria-valuenow="{{ $visibleTestimonialsRate }}">
                            <div class="progress-fill progress-coral" style="width: {{ $visibleTestimonialsRate }}%;"></div>
                        </div>
                    </div>

                    <hr class="my-3" style="border-color: var(--admin-border);">

                    <div class="insight-row">
                        <p class="insight-title">Lowest active price</p>
                        <p class="insight-value">₱{{ number_format($lowestPrice, 2) }}</p>
                    </div>
                    <div class="insight-row">
                        <p class="insight-title">Average rating</p>
                        <p class="insight-value">{{ number_format($averageRating, 1) }} / 5</p>
                    </div>
                </article>
            </div>

            <div class="col-lg-4">
                <article class="surface-panel h-100">
                    <div class="d-flex justify-content-between align-items-start gap-2">
                        <div>
                            <h3 class="panel-title">Recent Products</h3>
                            <p class="panel-subtitle">Latest catalog updates and status.</p>
                        </div>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-sm panel-action-btn">View all</a>
                    </div>

                    <div class="activity-list">
                        @forelse ($recentProducts as $product)
                            <div class="activity-item">
                                @if ($product->image)
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="activity-thumb">
                                @else
                                    <div class="activity-avatar"><i class="bi bi-image"></i></div>
                                @endif

                                <div class="flex-grow-1 min-width-0">
                                    <p class="activity-title">{{ $product->name }}</p>
                                    <p class="activity-meta">{{ $product->created_at->format('M d, Y h:i A') }}</p>
                                </div>

                                <div class="activity-side">
                                    <p class="activity-price">₱{{ number_format($product->price, 2) }}</p>
                                    <span class="badge-status {{ $product->is_active ? 'badge-active' : 'badge-inactive' }}">
                                        {{ $product->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4" style="color: var(--admin-text-muted);">
                                <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                <p class="mb-0 mt-2">No products yet.</p>
                            </div>
                        @endforelse
                    </div>
                </article>
            </div>

            <div class="col-lg-4">
                <article class="surface-panel h-100">
                    <div class="d-flex justify-content-between align-items-start gap-2">
                        <div>
                            <h3 class="panel-title">Recent Feedback</h3>
                            <p class="panel-subtitle">Latest customer voice and visibility state.</p>
                        </div>
                        <a href="{{ route('admin.testimonials.index') }}" class="btn btn-sm panel-action-btn">Review</a>
                    </div>

                    <div class="activity-list">
                        @forelse ($recentFeedback as $feedback)
                            <div class="activity-item">
                                <div class="activity-avatar">
                                    {{ strtoupper(substr($feedback->customer_name, 0, 1)) }}
                                </div>

                                <div class="flex-grow-1 min-width-0">
                                    <p class="activity-title">{{ $feedback->customer_name }}</p>
                                    <p class="activity-meta">{{ $feedback->created_at->format('M d, Y h:i A') }}</p>
                                </div>

                                <div class="activity-side">
                                    <p class="activity-price">{{ $feedback->rating }}/5</p>
                                    <p class="activity-snippet">{{ $feedback->is_visible ? 'Visible on site' : 'Hidden from site' }}</p>
                                    <p class="rating-stars mb-0" aria-label="{{ $feedback->rating }} stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi {{ $i <= $feedback->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                        @endfor
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4" style="color: var(--admin-text-muted);">
                                <i class="bi bi-chat-left" style="font-size: 2rem;"></i>
                                <p class="mb-0 mt-2">No feedback yet.</p>
                            </div>
                        @endforelse
                    </div>
                </article>
            </div>
        </section>

        <section class="surface-panel">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h3 class="panel-title">Quick Actions</h3>
                    <p class="panel-subtitle">Jump straight into common admin tasks.</p>
                </div>
            </div>

            <div class="quick-grid">
                <a href="{{ route('admin.products.index') }}" class="quick-link">
                    <span class="quick-link-icon"><i class="bi bi-box-seam-fill" style="color: var(--admin-primary);"></i></span>
                    <span>
                        <span class="quick-link-title">Manage Products</span>
                        <span class="quick-link-sub">Update menu items, pricing, and product status.</span>
                    </span>
                </a>
                <a href="{{ route('admin.locations.index') }}" class="quick-link">
                    <span class="quick-link-icon" style="border-color: rgba(21, 183, 140, 0.2); background: rgba(21, 183, 140, 0.1);"><i class="bi bi-geo-alt-fill" style="color: var(--admin-success);"></i></span>
                    <span>
                        <span class="quick-link-title">Manage Locations</span>
                        <span class="quick-link-sub">Adjust pinned branches, operating hours, and visibility.</span>
                    </span>
                </a>
                <a href="{{ route('admin.testimonials.index') }}" class="quick-link">
                    <span class="quick-link-icon" style="border-color: rgba(244, 82, 111, 0.24); background: rgba(244, 82, 111, 0.11);"><i class="bi bi-chat-left-text-fill" style="color: var(--admin-danger);"></i></span>
                    <span>
                        <span class="quick-link-title">Moderate Testimonials</span>
                        <span class="quick-link-sub">Review customer feedback and control homepage visibility.</span>
                    </span>
                </a>
                <a href="{{ route('admin.contacts.edit') }}" class="quick-link">
                    <span class="quick-link-icon" style="border-color: rgba(240, 154, 42, 0.24); background: rgba(240, 154, 42, 0.12);"><i class="bi bi-person-lines-fill" style="color: #d97706;"></i></span>
                    <span>
                        <span class="quick-link-title">Update Contact Info</span>
                        <span class="quick-link-sub">Keep address, phone, and service details accurate.</span>
                    </span>
                </a>
                <a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer" class="quick-link">
                    <span class="quick-link-icon" style="border-color: rgba(212, 175, 55, 0.24); background: rgba(212, 175, 55, 0.12);"><i class="bi bi-globe2" style="color: var(--admin-primary);"></i></span>
                    <span>
                        <span class="quick-link-title">Preview Website</span>
                        <span class="quick-link-sub">Open storefront in a new tab to verify changes quickly.</span>
                    </span>
                </a>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
<script>
    (function () {
        const greetingText = document.getElementById('dashboardGreetingText');
        const greetingIcon = document.getElementById('dashboardGreetingIcon');

        if (!greetingText || !greetingIcon) {
            return;
        }

        const now = new Date();
        const hour24 = now.getHours();

        let text = 'Good Evening';
        let icon = 'bi-moon-stars-fill';

        if (hour24 >= 5 && hour24 < 12) {
            text = 'Good Morning';
            icon = 'bi-sunrise-fill';
        } else if (hour24 >= 12 && hour24 < 18) {
            text = 'Good Afternoon';
            icon = 'bi-sun-fill';
        }

        greetingText.textContent = text;
        greetingIcon.className = `bi ${icon} me-2`;
    })();
</script>
@endpush
