<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @php
        $pageTitle = 'Pita Queen - Menu & Order';
        $pageDescription = 'Browse the Pita Queen menu, filter by category, and send your order quickly from your phone.';
        $pageCanonical = route('mobile.menu');
        $pageImage = asset('images/logo.png');
    @endphp
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ $pageDescription }}">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <link rel="canonical" href="{{ $pageCanonical }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDescription }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $pageCanonical }}">
    <meta property="og:image" content="{{ $pageImage }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $pageDescription }}">
    <meta name="twitter:image" content="{{ $pageImage }}">
    <title>{{ $pageTitle }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --gold: #D4AF37;
            --gold-light: #E5C158;
            --gold-dark: #B8942F;
            --bg-dark: #0D0D0D;
            --bg-card: #1A1A1A;
            --bg-surface: #2D2D2D;
            --text-primary: #FFFFFF;
            --text-secondary: #A0A0A0;
            --text-muted: #6B6B6B;
            --border: #333333;
            --success: #22c55e;
            --danger: #ef4444;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-primary);
            min-height: 100vh;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        /* Header */
        .mobile-header {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(13, 13, 13, 0.95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            padding: calc(0.75rem + env(safe-area-inset-top)) 1rem 0.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header-brand {
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .header-brand img {
            height: 32px;
            width: auto;
        }

        .header-brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--gold);
        }

        .btn-order-now {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: var(--gold);
            color: var(--bg-dark);
            font-family: 'Poppins', sans-serif;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.02em;
            border: none;
            border-radius: 999px;
            padding: 0.45rem 0.95rem;
            cursor: pointer;
            transition: background 0.18s, transform 0.18s;
            white-space: nowrap;
        }

        .btn-order-now:hover { background: var(--gold-light); }
        .btn-order-now:active { transform: scale(0.96); }
        .btn-order-now i { font-size: 0.8rem; }

        /* Page Hero */
        .menu-page-hero {
            padding: 1.75rem 1.25rem 1.5rem;
            background: linear-gradient(170deg, rgba(212,175,55,0.12) 0%, rgba(13,13,13,0) 60%);
            border-bottom: 1px solid rgba(212,175,55,0.15);
            text-align: center;
        }

        .hero-eyebrow {
            font-size: 0.68rem;
            font-weight: 600;
            color: var(--gold);
            letter-spacing: 0.14em;
            text-transform: uppercase;
            margin: 0 0 0.4rem;
        }

        .hero-heading {
            font-family: 'Playfair Display', serif;
            font-size: 2.4rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 0.35rem;
            line-height: 1.05;
        }

        .gold-text { color: var(--gold); }

        .hero-sub {
            font-size: 0.78rem;
            color: var(--text-muted);
            margin: 0;
        }

        .content-area {
            padding: 1.25rem;
            padding-bottom: 8rem;
        }

        .category-scroller {
            display: flex;
            gap: 0.45rem;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-bottom: 1.1rem;
            padding-bottom: 0.15rem;
        }

        .category-scroller::-webkit-scrollbar { display: none; }

        .category-chip {
            border: 1.5px solid rgba(255,255,255,0.1);
            background: rgba(255,255,255,0.04);
            color: var(--text-secondary);
            border-radius: 999px;
            padding: 0.42rem 0.9rem;
            font-size: 0.73rem;
            font-weight: 600;
            letter-spacing: 0.04em;
            white-space: nowrap;
            cursor: pointer;
            transition: all 0.18s ease;
        }

        .category-chip.active {
            color: var(--bg-dark);
            background: var(--gold);
            border-color: var(--gold);
            box-shadow: 0 2px 10px rgba(212,175,55,0.35);
        }

        .category-chip:not(.active):hover {
            border-color: rgba(212,175,55,0.4);
            color: var(--gold);
        }

        /* Menu Section */
        .menu-search {
            position: relative;
            margin-bottom: 1rem;
        }

        .menu-search input {
            width: 100%;
            background: rgba(255,255,255,0.05);
            border: 1.5px solid rgba(255,255,255,0.1);
            border-radius: 14px;
            padding: 0.8rem 1rem 0.8rem 2.85rem;
            color: var(--text-primary);
            font-family: 'Poppins', sans-serif;
            font-size: 0.85rem;
            transition: border-color 0.2s, background 0.2s;
        }

        .menu-search input:focus {
            outline: none;
            background: rgba(212,175,55,0.06);
            border-color: rgba(212,175,55,0.55);
        }

        .menu-search input::placeholder { color: var(--text-muted); }

        .menu-search i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        /* Menu Grid & Cards */
        #menuList {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
        }

        .menu-item {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
            transition: transform 0.18s ease, border-color 0.18s, box-shadow 0.18s;
            animation: cardIn 0.35s ease both;
        }

        @keyframes cardIn {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .menu-item:nth-child(even) { animation-delay: 0.07s; }

        .menu-item:active {
            transform: scale(0.97);
            border-color: rgba(212,175,55,0.45);
            box-shadow: 0 4px 20px rgba(212,175,55,0.12);
        }

        .mi-thumb {
            position: relative;
            width: 100%;
            aspect-ratio: 4 / 3;
            overflow: hidden;
            background: var(--bg-surface);
        }

        .mi-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.3s ease;
        }

        .menu-item:active .mi-img { transform: scale(1.04); }

        .mi-img-gradient {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(13,13,13,0.5) 0%, transparent 55%);
            pointer-events: none;
        }

        .mi-cat {
            position: absolute;
            top: 0.45rem;
            left: 0.45rem;
            background: rgba(0,0,0,0.65);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            border: 1px solid rgba(212,175,55,0.3);
            color: var(--gold);
            font-size: 0.6rem;
            font-weight: 700;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            border-radius: 6px;
            padding: 0.18rem 0.42rem;
        }

        .mi-body {
            padding: 0.65rem 0.75rem 0.75rem;
        }

        .mi-name {
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 0.2rem;
            line-height: 1.3;
        }

        .mi-desc {
            font-size: 0.68rem;
            color: var(--text-secondary);
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin: 0 0 0.5rem;
        }

        .mi-foot {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .mi-price {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--gold);
        }

        .btn-add-order {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: none;
            background: var(--gold);
            color: var(--bg-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 700;
            transition: background 0.18s, transform 0.18s, box-shadow 0.18s;
            cursor: pointer;
            flex-shrink: 0;
            position: relative;
            box-shadow: 0 4px 14px rgba(212,175,55,0.45);
        }

        /* Pulse ring */
        .btn-add-order::after {
            content: '';
            position: absolute;
            inset: -4px;
            border-radius: 50%;
            border: 2px solid rgba(212,175,55,0.45);
            animation: orderPulse 2.2s ease-in-out infinite;
            pointer-events: none;
        }

        @keyframes orderPulse {
            0%, 100% { transform: scale(1);   opacity: 0.6; }
            50%       { transform: scale(1.22); opacity: 0; }
        }

        .btn-add-order:hover {
            background: var(--gold-light);
            box-shadow: 0 6px 20px rgba(212,175,55,0.6);
            transform: scale(1.1);
        }

        .btn-add-order:active {
            transform: scale(0.93);
            box-shadow: 0 2px 8px rgba(212,175,55,0.3);
        }

        .empty-state {
            grid-column: 1 / -1;
            text-align: center;
            padding: 3rem 1rem;
            color: var(--text-muted);
        }

        .empty-state i { font-size: 3rem; margin-bottom: 0.75rem; display: block; }

        /* Delivery App Sheet */
        .delivery-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.72);
            z-index: 300;
            opacity: 0;
            pointer-events: none;
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            transition: opacity 0.32s ease;
        }

        .delivery-overlay.show {
            opacity: 1;
            pointer-events: auto;
        }

        .delivery-sheet {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 301;
            background: linear-gradient(180deg, #252525 0%, #141414 100%);
            border-radius: 32px 32px 0 0;
            padding: 0 1.25rem calc(2.5rem + env(safe-area-inset-bottom));
            transform: translateY(100%);
            transition: transform 0.5s cubic-bezier(0.34, 1.28, 0.64, 1);
            box-shadow: 0 -16px 60px rgba(0,0,0,0.75), 0 -1px 0 rgba(212,175,55,0.28);
            will-change: transform;
        }

        .delivery-sheet.show { transform: translateY(0); }

        /* Gold glow line at top edge */
        .delivery-sheet::before {
            content: '';
            position: absolute;
            top: 0; left: 50%;
            transform: translateX(-50%);
            width: 55%;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(212,175,55,0.6), transparent);
            pointer-events: none;
        }

        .delivery-sheet-handle {
            width: 40px;
            height: 4px;
            background: rgba(255,255,255,0.08);
            border-radius: 2px;
            margin: 1.1rem auto 1.5rem;
            position: relative;
            overflow: hidden;
        }

        /* Shimmer sweep across handle when sheet opens */
        .delivery-sheet.show .delivery-sheet-handle::after {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(212,175,55,0.9), transparent);
            animation: handleShimmer 1.6s ease 0.5s forwards;
        }

        @keyframes handleShimmer {
            from { left: -100%; }
            to   { left: 200%; }
        }

        .delivery-sheet-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 1.4rem;
            gap: 0.75rem;
        }

        .delivery-sheet-heading-wrap { flex: 1; min-width: 0; }

        .delivery-sheet-heading {
            font-family: 'Playfair Display', serif;
            font-size: 1.35rem;
            font-weight: 700;
            margin: 0 0 0.22rem;
            line-height: 1.2;
        }

        .delivery-sheet-sub {
            font-size: 0.7rem;
            color: var(--text-muted);
            margin: 0;
            letter-spacing: 0.01em;
        }

        .delivery-sheet-close {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.08);
            background: rgba(255,255,255,0.04);
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 0.75rem;
            flex-shrink: 0;
            transition: background 0.18s, border-color 0.18s, color 0.18s, transform 0.28s;
        }

        .delivery-sheet-close:hover {
            border-color: rgba(255,255,255,0.2);
            background: rgba(255,255,255,0.08);
            color: var(--text-primary);
            transform: rotate(90deg);
        }

        .delivery-app-list {
            display: flex;
            flex-direction: column;
            gap: 0.55rem;
        }

        .delivery-app-row {
            display: flex;
            align-items: center;
            gap: 0.9rem;
            padding: 0.8rem 0.85rem;
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 20px;
            background: rgba(255,255,255,0.03);
            cursor: pointer;
            transition: border-color 0.22s, background 0.22s, box-shadow 0.22s, transform 0.16s;
            text-align: left;
            opacity: 0;
            transform: translateY(18px) scale(0.96);
            position: relative;
            overflow: hidden;
            will-change: transform, opacity;
        }

        .delivery-sheet.show .delivery-app-row {
            animation: rowSlideIn 0.4s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }

        .delivery-sheet.show .delivery-app-row:nth-child(1) { animation-delay: 0.08s; }
        .delivery-sheet.show .delivery-app-row:nth-child(2) { animation-delay: 0.15s; }
        .delivery-sheet.show .delivery-app-row:nth-child(3) { animation-delay: 0.22s; }
        .delivery-sheet.show .delivery-app-row:nth-child(4) { animation-delay: 0.29s; }

        @keyframes rowSlideIn {
            from { opacity: 0; transform: translateY(18px) scale(0.96); filter: blur(3px); }
            to   { opacity: 1; transform: translateY(0)   scale(1);    filter: blur(0); }
        }

        .delivery-app-row:hover  { transform: translateY(-2px); }
        .delivery-app-row:active { transform: scale(0.97) !important; }

        /* Per-brand colour glow on hover */
        .delivery-app-row[data-app="ubereats"]:hover {
            border-color: rgba(6,193,103,0.4);
            background: rgba(6,193,103,0.07);
            box-shadow: 0 6px 24px rgba(6,193,103,0.16);
        }
        .delivery-app-row[data-app="doordash"]:hover {
            border-color: rgba(255,48,8,0.4);
            background: rgba(255,48,8,0.07);
            box-shadow: 0 6px 24px rgba(255,48,8,0.16);
        }
        .delivery-app-row[data-app="grubhub"]:hover {
            border-color: rgba(246,52,64,0.4);
            background: rgba(246,52,64,0.07);
            box-shadow: 0 6px 24px rgba(246,52,64,0.16);
        }
        /* Touch ripple */
        .delivery-app-row .ripple-dot {
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.12);
            pointer-events: none;
            transform: scale(0);
            animation: rippleOut 0.55s ease-out forwards;
        }

        @keyframes rippleOut {
            to { transform: scale(1); opacity: 0; }
        }

        .app-logo-box {
            width: 52px;
            height: 52px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            padding: 10px;
            transition: transform 0.22s, box-shadow 0.22s;
        }

        .app-logo-box img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
            filter: brightness(0) invert(1);
        }

        .delivery-app-row:hover .app-logo-box { transform: scale(1.08); }

        .app-logo-ubereats  { background: #06C167; box-shadow: 0 6px 18px rgba(6,193,103,0.5); }
        .app-logo-doordash  { background: #FF3008; box-shadow: 0 6px 18px rgba(255,48,8,0.5); }
        .app-logo-grubhub   { background: #F63440; box-shadow: 0 6px 18px rgba(246,52,64,0.5); }

        .app-text-col { flex: 1; min-width: 0; }

        .app-row-name {
            font-size: 0.92rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 0.12rem;
            letter-spacing: -0.01em;
        }

        .app-row-tag {
            font-size: 0.68rem;
            color: var(--text-muted);
            margin: 0;
        }

        .app-row-chevron {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: rgba(255,255,255,0.05);
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            color: rgba(255,255,255,0.22);
            font-size: 0.7rem;
            flex-shrink: 0;
            transition: background 0.22s, color 0.22s, transform 0.22s;
        }

        .delivery-app-row:hover .app-row-chevron {
            background: rgba(212,175,55,0.14);
            color: var(--gold);
            transform: translateX(3px);
        }

        /* No results */
        .no-results {
            grid-column: 1 / -1;
            text-align: center;
            padding: 2.5rem 1rem;
            display: none;
        }

        .no-results i { font-size: 2.5rem; color: var(--text-muted); display: block; margin-bottom: 0.5rem; }
        .no-results p { font-size: 0.85rem; color: var(--text-muted); }
    </style>
</head>
<body>
    {{-- Header --}}
    <header class="mobile-header">
        <div class="header-brand">
            <img src="/images/logo.png" alt="Pita Queen">
            <span class="header-brand-name">Pita Queen</span>
        </div>
        <button class="btn-order-now" onclick="openDeliverySheet()">
            <i class="bi bi-bag-fill"></i> Order Now
        </button>
    </header>

    {{-- Page Hero --}}
    <div class="menu-page-hero">
        <p class="hero-eyebrow">Freshly made daily</p>
        <h1 class="hero-heading">Our <span class="gold-text">Menu</span></h1>
        <p class="hero-sub">{{ $menuItems->count() }} handcrafted items</p>
    </div>

    <div class="content-area">
        <div class="menu-search">
            <i class="bi bi-search"></i>
            <input type="text" id="menuSearch" placeholder="Search our menu...">
        </div>

        <div class="category-scroller" id="categoryScroller">
            <button type="button" class="category-chip active" data-category="all">All</button>
            @foreach($menuCategories as $menuCategory)
                <button type="button" class="category-chip" data-category="{{ \Illuminate\Support\Str::slug($menuCategory) }}">{{ $menuCategory }}</button>
            @endforeach
        </div>

        <div id="menuList">
            @forelse ($menuItems as $item)
                @php $imageUrl = $item->image_url; @endphp
                <div class="menu-item" data-name="{{ strtolower($item->name) }}" data-category="{{ \Illuminate\Support\Str::slug((string) $item->category) }}" data-id="{{ $item->id }}">
                    <div class="mi-thumb">
                        <img src="{{ $imageUrl }}" alt="{{ $item->name }}" class="mi-img" loading="lazy">
                        <div class="mi-img-gradient"></div>
                        @if($item->category)
                            <span class="mi-cat">{{ $item->category }}</span>
                        @endif
                    </div>
                    <div class="mi-body">
                        <p class="mi-name">{{ $item->name }}</p>
                        @if($item->description)
                            <p class="mi-desc">{{ $item->description }}</p>
                        @endif
                        <div class="mi-foot">
                            <span class="mi-price">₱{{ number_format($item->price, 2) }}</span>
                            <button class="btn-add-order" data-id="{{ $item->id }}" data-name="{{ $item->name }}" data-price="{{ $item->price }}" aria-label="Order {{ $item->name }}">
                                <i class="bi bi-bag-fill"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <p>No menu items available yet.<br>Check back soon!</p>
                </div>
            @endforelse
        </div>

        <div class="no-results" id="noResults">
            <i class="bi bi-search"></i>
            <p>No items match your search.</p>
        </div>
    </div>

    {{-- Delivery App Sheet --}}
    <div class="delivery-overlay" id="deliveryOverlay" onclick="closeDeliverySheet()"></div>
    <div class="delivery-sheet" id="deliverySheet">
        <div class="delivery-sheet-handle"></div>
        <div class="delivery-sheet-header">
            <div class="delivery-sheet-heading-wrap">
                <h2 class="delivery-sheet-heading">Order <span style="color:var(--gold)">Delivery</span></h2>
                <p class="delivery-sheet-sub">Choose your delivery partner</p>
            </div>
            <button class="delivery-sheet-close" onclick="closeDeliverySheet()" aria-label="Close">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="delivery-app-list">
            <button class="delivery-app-row" data-app="ubereats" onclick="openDeliveryApp('ubereats')">
                <div class="app-logo-box app-logo-ubereats">
                    <img src="https://cdn.jsdelivr.net/npm/simple-icons@latest/icons/ubereats.svg" alt="Uber Eats" loading="lazy" onerror="this.style.display='none'">
                </div>
                <div class="app-text-col">
                    <p class="app-row-name">Uber Eats</p>
                    <p class="app-row-tag">Fast delivery &middot; Track in real time</p>
                </div>
                <i class="bi bi-chevron-right app-row-chevron"></i>
            </button>
            <button class="delivery-app-row" data-app="doordash" onclick="openDeliveryApp('doordash')">
                <div class="app-logo-box app-logo-doordash">
                    <img src="https://cdn.jsdelivr.net/npm/simple-icons@latest/icons/doordash.svg" alt="DoorDash" loading="lazy" onerror="this.style.display='none'">
                </div>
                <div class="app-text-col">
                    <p class="app-row-name">DoorDash</p>
                    <p class="app-row-tag">On-demand delivery &middot; Wide selection</p>
                </div>
                <i class="bi bi-chevron-right app-row-chevron"></i>
            </button>
            <button class="delivery-app-row" data-app="grubhub" onclick="openDeliveryApp('grubhub')">
                <div class="app-logo-box app-logo-grubhub">
                    <img src="https://cdn.jsdelivr.net/npm/simple-icons@latest/icons/grubhub.svg" alt="Grubhub" loading="lazy" onerror="this.style.display='none'">
                </div>
                <div class="app-text-col">
                    <p class="app-row-name">Grubhub</p>
                    <p class="app-row-tag">Thousands of restaurants nearby</p>
                </div>
                <i class="bi bi-chevron-right app-row-chevron"></i>
            </button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let activeCategory = 'all';

        function applyMenuFilters() {
            const query = (document.getElementById('menuSearch').value || '').toLowerCase().trim();
            let visible = 0;

            document.querySelectorAll('.menu-item').forEach(item => {
                const matchesSearch = item.dataset.name.includes(query);
                const itemCategory = item.dataset.category || '';
                const matchesCategory = activeCategory === 'all' || itemCategory === activeCategory;
                const show = matchesSearch && matchesCategory;

                item.style.display = show ? '' : 'none';
                if (show) {
                    visible += 1;
                }
            });

            document.getElementById('noResults').style.display = visible === 0 ? 'block' : 'none';
        }

        document.getElementById('menuSearch').addEventListener('input', applyMenuFilters);
        document.querySelectorAll('.category-chip').forEach((chip) => {
            chip.addEventListener('click', function () {
                document.querySelectorAll('.category-chip').forEach((item) => item.classList.remove('active'));
                this.classList.add('active');
                activeCategory = this.dataset.category || 'all';
                applyMenuFilters();
            });
        });

        // ── Delivery App Sheet ──
        const deliveryApps = {
            ubereats:  { deepLink: 'ubereats://',  fallback: 'https://www.ubereats.com' },
            doordash:  { deepLink: 'doordash://',  fallback: 'https://www.doordash.com' },
            grubhub:   { deepLink: 'grubhub://',   fallback: 'https://www.grubhub.com' },
        };

        function openDeliverySheet() {
            document.getElementById('deliveryOverlay').classList.add('show');
            document.getElementById('deliverySheet').classList.add('show');
        }

        function closeDeliverySheet() {
            document.getElementById('deliveryOverlay').classList.remove('show');
            document.getElementById('deliverySheet').classList.remove('show');
        }

        // Touch ripple on delivery rows
        document.querySelectorAll('.delivery-app-row').forEach(function (row) {
            row.addEventListener('pointerdown', function (e) {
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height) * 2;
                const dot  = document.createElement('span');
                dot.className = 'ripple-dot';
                dot.style.cssText = 'width:' + size + 'px;height:' + size + 'px;left:' + (e.clientX - rect.left - size / 2) + 'px;top:' + (e.clientY - rect.top - size / 2) + 'px';
                this.appendChild(dot);
                dot.addEventListener('animationend', function () { dot.remove(); });
            });
        });

        function openDeliveryApp(key) {
            const app = deliveryApps[key];
            if (!app) { return; }
            closeDeliverySheet();

            // Use a hidden iframe so the deep-link attempt does not navigate
            // the page or show a browser-level "no handler" error.
            const iframe = document.createElement('iframe');
            iframe.style.cssText = 'position:fixed;top:-9999px;left:-9999px;width:1px;height:1px;';
            iframe.src = app.deepLink;
            document.body.appendChild(iframe);

            // If the native app opens, the page will become hidden.
            // If it stays visible after the grace period, fall back to the web URL.
            let opened = false;
            const onHide = () => { opened = true; };
            document.addEventListener('visibilitychange', onHide, { once: true });

            setTimeout(() => {
                document.removeEventListener('visibilitychange', onHide);
                document.body.removeChild(iframe);
                if (!opened) {
                    window.open(app.fallback, '_blank');
                }
            }, 1400);
        }

        document.querySelectorAll('.btn-add-order').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.stopPropagation();
                openDeliverySheet();
            });
        });

        applyMenuFilters();
    </script>
</body>
</html>
