<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @php
        $pageTitle = 'Pita Queen - Menu & Order';
        $pageDescription = 'Browse the Pita Queen menu, pick your favorites, and send your order quickly from your phone. Fresh Mediterranean meals, shawarma, and more.';
        $pageCanonical = route('mobile.menu');
        $pageImage = asset('images/logo.png');
    @endphp
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
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
            padding: 1rem 1.25rem;
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

        /* Tab Navigation */
        .tab-nav {
            display: flex;
            background: var(--bg-card);
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 65px;
            z-index: 99;
        }

        .tab-btn {
            flex: 1;
            padding: 0.85rem 0.5rem;
            background: none;
            border: none;
            border-bottom: 2px solid transparent;
            color: var(--text-muted);
            font-family: 'Poppins', sans-serif;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.2s ease;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
        }

        .tab-btn.active {
            color: var(--gold);
            border-bottom-color: var(--gold);
        }

        .tab-btn i { font-size: 1rem; }

        /* Section containers */
        .tab-content { display: none; }
        .tab-content.active { display: block; }

        .content-area {
            padding: 1.25rem;
            padding-bottom: 6rem;
        }

        /* Menu Section */
        .menu-search {
            position: relative;
            margin-bottom: 1.25rem;
        }

        .menu-search input {
            width: 100%;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 0.75rem 1rem 0.75rem 2.75rem;
            color: var(--text-primary);
            font-family: 'Poppins', sans-serif;
            font-size: 0.85rem;
            transition: border-color 0.2s;
        }

        .menu-search input:focus {
            outline: none;
            border-color: var(--gold);
        }

        .menu-search input::placeholder { color: var(--text-muted); }

        .menu-search i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }

        /* Menu Item Card */
        .menu-item {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 14px;
            overflow: hidden;
            margin-bottom: 1rem;
            transition: transform 0.2s, border-color 0.2s;
        }

        .menu-item:active {
            transform: scale(0.98);
        }

        .menu-item-inner {
            display: flex;
            padding: 0.85rem;
            gap: 0.85rem;
        }

        .menu-item-img {
            width: 80px;
            height: 80px;
            border-radius: 10px;
            object-fit: cover;
            flex-shrink: 0;
        }

        .menu-item-img-placeholder {
            width: 80px;
            height: 80px;
            border-radius: 10px;
            background: var(--bg-surface);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .menu-item-info { flex: 1; min-width: 0; }

        .menu-item-name {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.2rem;
        }

        .menu-item-desc {
            font-size: 0.75rem;
            color: var(--text-secondary);
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            margin-bottom: 0.5rem;
        }

        .menu-item-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .menu-item-price {
            font-size: 1rem;
            font-weight: 700;
            color: var(--gold);
        }

        .menu-item-price small {
            font-size: 0.7rem;
            font-weight: 400;
            color: var(--text-muted);
        }

        .btn-add-order {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: 1px solid var(--gold);
            background: rgba(212, 175, 55, 0.1);
            color: var(--gold);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            transition: all 0.2s;
            cursor: pointer;
        }

        .btn-add-order:hover, .btn-add-order:active {
            background: var(--gold);
            color: var(--bg-dark);
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: var(--text-muted);
        }

        .empty-state i { font-size: 3rem; margin-bottom: 0.75rem; display: block; }

        /* Order Cart */
        .cart-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(13, 13, 13, 0.97);
            backdrop-filter: blur(12px);
            border-top: 1px solid var(--border);
            padding: 0.85rem 1.25rem;
            z-index: 200;
            transform: translateY(100%);
            transition: transform 0.3s ease;
        }

        .cart-bar.show { transform: translateY(0); }

        .cart-bar-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .cart-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .cart-badge {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: var(--gold);
            color: var(--bg-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
        }

        .cart-count { font-size: 0.8rem; color: var(--text-secondary); }
        .cart-total { font-size: 1rem; font-weight: 700; color: var(--text-primary); }

        .btn-view-order {
            background: var(--gold);
            color: var(--bg-dark);
            border: none;
            border-radius: 10px;
            padding: 0.6rem 1.25rem;
            font-family: 'Poppins', sans-serif;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-view-order:hover { background: var(--gold-light); }

        /* Order Summary Modal */
        .order-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.7);
            z-index: 300;
            display: none;
        }

        .order-overlay.show { display: block; }

        .order-sheet {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 301;
            background: var(--bg-card);
            border-radius: 20px 20px 0 0;
            max-height: 85vh;
            overflow-y: auto;
            transform: translateY(100%);
            transition: transform 0.3s ease;
            padding: 1.5rem 1.25rem;
        }

        .order-sheet.show { transform: translateY(0); }

        .order-sheet-handle {
            width: 40px;
            height: 4px;
            border-radius: 2px;
            background: var(--bg-surface);
            margin: 0 auto 1.25rem;
        }

        .order-sheet-title {
            font-size: 1.15rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .order-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--border);
        }

        .order-item-left { display: flex; align-items: center; gap: 0.75rem; }

        .order-qty-controls {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .qty-btn {
            width: 28px;
            height: 28px;
            border-radius: 6px;
            border: 1px solid var(--border);
            background: transparent;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            cursor: pointer;
        }

        .qty-btn:hover { border-color: var(--gold); color: var(--gold); }

        .order-item-qty {
            font-size: 0.85rem;
            font-weight: 600;
            min-width: 20px;
            text-align: center;
        }

        .order-item-name { font-size: 0.85rem; font-weight: 500; }
        .order-item-price { font-size: 0.85rem; font-weight: 600; color: var(--gold); white-space: nowrap; }

        .order-total-row {
            display: flex;
            justify-content: space-between;
            padding: 1rem 0 0.5rem;
            font-size: 1.1rem;
            font-weight: 700;
        }

        .order-total-row .gold { color: var(--gold); }

        .btn-place-order {
            width: 100%;
            background: var(--gold);
            color: var(--bg-dark);
            border: none;
            border-radius: 12px;
            padding: 0.85rem;
            font-family: 'Poppins', sans-serif;
            font-size: 0.95rem;
            font-weight: 700;
            margin-top: 1rem;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-place-order:hover { background: var(--gold-light); }

        /* Feedback Section */
        .feedback-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .feedback-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .feedback-header p {
            font-size: 0.8rem;
            color: var(--text-secondary);
        }

        .feedback-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 1.5rem;
        }

        .fb-field {
            margin-bottom: 1.25rem;
        }

        .fb-label {
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-secondary);
            margin-bottom: 0.4rem;
        }

        .fb-input, .fb-textarea {
            width: 100%;
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 0.7rem 0.85rem;
            color: var(--text-primary);
            font-family: 'Poppins', sans-serif;
            font-size: 0.85rem;
            transition: border-color 0.2s;
        }

        .fb-input:focus, .fb-textarea:focus {
            outline: none;
            border-color: var(--gold);
        }

        .fb-input::placeholder, .fb-textarea::placeholder { color: var(--text-muted); }

        .fb-textarea { min-height: 120px; resize: vertical; }

        /* Star Rating */
        .star-rating {
            display: flex;
            gap: 0.5rem;
            flex-direction: row-reverse;
            justify-content: flex-end;
        }

        .star-rating input { display: none; }

        .star-rating label {
            font-size: 1.75rem;
            color: var(--border);
            cursor: pointer;
            transition: color 0.15s;
        }

        .star-rating input:checked ~ label,
        .star-rating label:hover,
        .star-rating label:hover ~ label {
            color: var(--gold);
        }

        .btn-submit-feedback {
            width: 100%;
            background: var(--gold);
            color: var(--bg-dark);
            border: none;
            border-radius: 12px;
            padding: 0.85rem;
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-submit-feedback:hover { background: var(--gold-light); }

        .btn-submit-feedback:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .feedback-success {
            text-align: center;
            padding: 2rem 0;
            display: none;
        }

        .feedback-success.show { display: block; }

        .feedback-success i {
            font-size: 3.5rem;
            color: var(--success);
            display: block;
            margin-bottom: 0.75rem;
        }

        .feedback-success h3 {
            font-size: 1.15rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .feedback-success p {
            font-size: 0.8rem;
            color: var(--text-secondary);
        }

        .fb-error {
            color: var(--danger);
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }

        /* Contact Info Bar */
        .contact-bar {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 1.25rem;
            margin-bottom: 1.25rem;
        }

        .contact-bar-item {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.4rem 0;
        }

        .contact-bar-item i {
            color: var(--gold);
            font-size: 0.9rem;
            width: 20px;
            text-align: center;
        }

        .contact-bar-item span,
        .contact-bar-item a {
            font-size: 0.8rem;
            color: var(--text-secondary);
            text-decoration: none;
        }

        .contact-bar-item a:hover { color: var(--gold); }

        /* Toast */
        .mobile-toast {
            position: fixed;
            top: 1rem;
            left: 50%;
            transform: translateX(-50%) translateY(-120%);
            background: var(--bg-card);
            border: 1px solid var(--gold);
            border-radius: 12px;
            padding: 0.75rem 1.25rem;
            z-index: 999;
            color: var(--text-primary);
            font-size: 0.85rem;
            font-weight: 500;
            transition: transform 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            white-space: nowrap;
        }

        .mobile-toast.show {
            transform: translateX(-50%) translateY(0);
        }

        .mobile-toast i { color: var(--gold); }

        /* No results */
        .no-results {
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
    </header>

    {{-- Tab Navigation --}}
    <nav class="tab-nav">
        <button class="tab-btn active" data-tab="menu">
            <i class="bi bi-grid-fill"></i> Menu
        </button>
        <button class="tab-btn" data-tab="feedback">
            <i class="bi bi-chat-heart-fill"></i> Feedback
        </button>
        <button class="tab-btn" data-tab="info">
            <i class="bi bi-info-circle-fill"></i> Info
        </button>
    </nav>

    {{-- ═══ Menu Tab ═══ --}}
    <div class="tab-content active" id="tab-menu">
        <div class="content-area">
            <div class="menu-search">
                <i class="bi bi-search"></i>
                <input type="text" id="menuSearch" placeholder="Search our menu...">
            </div>

            <div id="menuList">
                @forelse ($menuItems as $item)
                    @php
                        $imageUrl = $item->image
                            ? (str_starts_with($item->image, 'http') ? $item->image : asset('storage/' . $item->image))
                            : null;
                    @endphp
                    <div class="menu-item" data-name="{{ strtolower($item->name) }}" data-id="{{ $item->id }}">
                        <div class="menu-item-inner">
                            @if ($imageUrl)
                                <img src="{{ $imageUrl }}" alt="{{ $item->name }}" class="menu-item-img" loading="lazy">
                            @else
                                <div class="menu-item-img-placeholder">
                                    <i class="bi bi-egg-fried"></i>
                                </div>
                            @endif

                            <div class="menu-item-info">
                                <div class="menu-item-name">{{ $item->name }}</div>
                                @if ($item->description)
                                    <div class="menu-item-desc">{{ $item->description }}</div>
                                @endif
                                <div class="menu-item-bottom">
                                    <span class="menu-item-price">₱{{ number_format($item->price, 2) }}</span>
                                    <button class="btn-add-order" data-id="{{ $item->id }}" data-name="{{ $item->name }}" data-price="{{ $item->price }}">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="bi bi-inbox"></i>
                        <p>No menu items available yet.<br>Please check back soon!</p>
                    </div>
                @endforelse
            </div>

            <div class="no-results" id="noResults">
                <i class="bi bi-search"></i>
                <p>No items match your search.</p>
            </div>
        </div>
    </div>

    {{-- ═══ Feedback Tab ═══ --}}
    <div class="tab-content" id="tab-feedback">
        <div class="content-area">
            <div class="feedback-header">
                <h2>Share Your <span style="color: var(--gold);">Experience</span></h2>
                <p>We'd love to hear your thoughts about our food & service</p>
            </div>

            <div class="feedback-card" id="feedbackFormCard">
                <form id="feedbackForm">
                    <div class="fb-field">
                        <label class="fb-label">Your Name</label>
                        <input type="text" name="customer_name" class="fb-input" placeholder="Enter your name" required>
                        <div class="fb-error" id="err_customer_name"></div>
                    </div>

                    <div class="fb-field">
                        <label class="fb-label">Email <span style="color:var(--text-muted);font-weight:400">(optional)</span></label>
                        <input type="email" name="customer_email" class="fb-input" placeholder="your@email.com">
                        <div class="fb-error" id="err_customer_email"></div>
                    </div>

                    <div class="fb-field">
                        <label class="fb-label">Rating</label>
                        <div class="star-rating">
                            <input type="radio" name="rating" value="5" id="star5" checked>
                            <label for="star5"><i class="bi bi-star-fill"></i></label>
                            <input type="radio" name="rating" value="4" id="star4">
                            <label for="star4"><i class="bi bi-star-fill"></i></label>
                            <input type="radio" name="rating" value="3" id="star3">
                            <label for="star3"><i class="bi bi-star-fill"></i></label>
                            <input type="radio" name="rating" value="2" id="star2">
                            <label for="star2"><i class="bi bi-star-fill"></i></label>
                            <input type="radio" name="rating" value="1" id="star1">
                            <label for="star1"><i class="bi bi-star-fill"></i></label>
                        </div>
                        <div class="fb-error" id="err_rating"></div>
                    </div>

                    <div class="fb-field">
                        <label class="fb-label">Your Feedback</label>
                        <textarea name="message" class="fb-textarea" placeholder="Tell us about your experience..." required></textarea>
                        <div class="fb-error" id="err_message"></div>
                    </div>

                    <button type="submit" class="btn-submit-feedback" id="submitFeedbackBtn">
                        <i class="bi bi-send me-1"></i> Submit Feedback
                    </button>
                </form>
            </div>

            <div class="feedback-success" id="feedbackSuccess">
                <i class="bi bi-heart-fill"></i>
                <h3>Thank You!</h3>
                <p>Your feedback means everything to us.</p>
                <button class="btn-submit-feedback mt-3" onclick="resetFeedbackForm()" style="max-width: 200px; margin: 0 auto; display: block;">
                    Submit Another
                </button>
            </div>
        </div>
    </div>

    {{-- ═══ Info Tab ═══ --}}
    <div class="tab-content" id="tab-info">
        <div class="content-area">
            <div class="feedback-header">
                <h2>Visit <span style="color: var(--gold);">Pita Queen</span></h2>
                <p>Find us at our location</p>
            </div>

            <div class="contact-bar">
                <div class="contact-bar-item">
                    <i class="bi bi-geo-alt-fill"></i>
                    <span>{{ $contactSettings['contact_address_line1'] }}, {{ $contactSettings['contact_address_line2'] }}</span>
                </div>
                <div class="contact-bar-item">
                    <i class="bi bi-telephone-fill"></i>
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $contactSettings['contact_phone']) }}">{{ $contactSettings['contact_phone'] }}</a>
                </div>
                <div class="contact-bar-item">
                    <i class="bi bi-envelope-fill"></i>
                    <a href="mailto:{{ $contactSettings['contact_email'] }}">{{ $contactSettings['contact_email'] }}</a>
                </div>
                <div class="contact-bar-item">
                    <i class="bi bi-clock-fill"></i>
                    <span>{{ $contactSettings['contact_hours'] }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Cart Bottom Bar --}}
    <div class="cart-bar" id="cartBar">
        <div class="cart-bar-inner">
            <div class="cart-info">
                <div class="cart-badge" id="cartCount">0</div>
                <div>
                    <div class="cart-count"><span id="cartItemCount">0</span> items</div>
                    <div class="cart-total">₱<span id="cartTotal">0.00</span></div>
                </div>
            </div>
            <button class="btn-view-order" onclick="openOrderSheet()">View Order</button>
        </div>
    </div>

    {{-- Order Sheet --}}
    <div class="order-overlay" id="orderOverlay" onclick="closeOrderSheet()"></div>
    <div class="order-sheet" id="orderSheet">
        <div class="order-sheet-handle"></div>
        <div class="order-sheet-title">Your Order</div>
        <div id="orderItems"></div>
        <div class="order-total-row">
            <span>Total</span>
            <span class="gold">₱<span id="orderTotal">0.00</span></span>
        </div>
        <button class="btn-place-order" onclick="placeOrder()">
            <i class="bi bi-bag-check me-1"></i> Place Order
        </button>
    </div>

    {{-- Toast --}}
    <div class="mobile-toast" id="mobileToast">
        <i class="bi bi-check-circle-fill"></i>
        <span id="toastMsg"></span>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // ── Tab Switching ──
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
                this.classList.add('active');
                document.getElementById('tab-' + this.dataset.tab).classList.add('active');
            });
        });

        // ── Menu Search ──
        document.getElementById('menuSearch').addEventListener('input', function () {
            const q = this.value.toLowerCase().trim();
            let visible = 0;
            document.querySelectorAll('.menu-item').forEach(item => {
                const show = item.dataset.name.includes(q);
                item.style.display = show ? '' : 'none';
                if (show) visible++;
            });
            document.getElementById('noResults').style.display = visible === 0 ? 'block' : 'none';
        });

        // ── Cart ──
        let cart = {};

        function addToCart(id, name, price) {
            if (cart[id]) {
                cart[id].qty++;
            } else {
                cart[id] = { name, price: parseFloat(price), qty: 1 };
            }
            updateCartUI();
            showToast(name + ' added');
        }

        function updateCartUI() {
            let totalItems = 0, totalPrice = 0;
            Object.values(cart).forEach(item => {
                totalItems += item.qty;
                totalPrice += item.qty * item.price;
            });

            document.getElementById('cartCount').textContent = totalItems;
            document.getElementById('cartItemCount').textContent = totalItems;
            document.getElementById('cartTotal').textContent = totalPrice.toFixed(2);
            document.getElementById('orderTotal').textContent = totalPrice.toFixed(2);

            const bar = document.getElementById('cartBar');
            if (totalItems > 0) {
                bar.classList.add('show');
            } else {
                bar.classList.remove('show');
            }

            renderOrderItems();
        }

        function renderOrderItems() {
            const container = document.getElementById('orderItems');
            container.innerHTML = '';
            Object.entries(cart).forEach(([id, item]) => {
                container.innerHTML += `
                    <div class="order-item">
                        <div class="order-item-left">
                            <div class="order-qty-controls">
                                <button class="qty-btn" onclick="changeQty('${id}', -1)"><i class="bi bi-dash"></i></button>
                                <span class="order-item-qty">${item.qty}</span>
                                <button class="qty-btn" onclick="changeQty('${id}', 1)"><i class="bi bi-plus"></i></button>
                            </div>
                            <span class="order-item-name">${item.name}</span>
                        </div>
                        <span class="order-item-price">₱${(item.qty * item.price).toFixed(2)}</span>
                    </div>`;
            });
        }

        function changeQty(id, delta) {
            if (!cart[id]) return;
            cart[id].qty += delta;
            if (cart[id].qty <= 0) delete cart[id];
            updateCartUI();
            if (Object.keys(cart).length === 0) closeOrderSheet();
        }

        function openOrderSheet() {
            document.getElementById('orderOverlay').classList.add('show');
            document.getElementById('orderSheet').classList.add('show');
        }

        function closeOrderSheet() {
            document.getElementById('orderOverlay').classList.remove('show');
            document.getElementById('orderSheet').classList.remove('show');
        }

        function placeOrder() {
            const phone = "{{ preg_replace('/[^0-9+]/', '', $contactSettings['contact_phone']) }}";
            let msg = "Hi! I'd like to place an order:\n\n";
            let total = 0;
            Object.values(cart).forEach(item => {
                const sub = item.qty * item.price;
                msg += `${item.qty}x ${item.name} - ₱${sub.toFixed(2)}\n`;
                total += sub;
            });
            msg += `\nTotal: ₱${total.toFixed(2)}\n\nThank you!`;

            const cleanPhone = phone.replace('+', '');
            window.open('https://wa.me/' + cleanPhone + '?text=' + encodeURIComponent(msg), '_blank');

            cart = {};
            updateCartUI();
            closeOrderSheet();
            showToast('Order sent via WhatsApp!');
        }

        // Add-to-cart button handlers
        document.querySelectorAll('.btn-add-order').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.stopPropagation();
                addToCart(this.dataset.id, this.dataset.name, this.dataset.price);
            });
        });

        // ── Toast ──
        function showToast(msg) {
            const toast = document.getElementById('mobileToast');
            document.getElementById('toastMsg').textContent = msg;
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 2000);
        }

        // ── Feedback ──
        const feedbackForm = document.getElementById('feedbackForm');
        feedbackForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            const btn = document.getElementById('submitFeedbackBtn');
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Sending...';

            // Clear errors
            document.querySelectorAll('.fb-error').forEach(el => el.textContent = '');

            const data = new FormData(this);
            try {
                const res = await fetch("{{ route('mobile.feedback') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: data,
                });

                if (res.status === 422) {
                    const json = await res.json();
                    Object.entries(json.errors || {}).forEach(([key, msgs]) => {
                        const el = document.getElementById('err_' + key);
                        if (el) el.textContent = msgs[0];
                    });
                } else if (res.ok) {
                    document.getElementById('feedbackFormCard').style.display = 'none';
                    document.getElementById('feedbackSuccess').classList.add('show');
                }
            } catch (err) {
                showToast('Something went wrong. Please try again.');
            }

            btn.disabled = false;
            btn.innerHTML = '<i class="bi bi-send me-1"></i> Submit Feedback';
        });

        function resetFeedbackForm() {
            feedbackForm.reset();
            document.getElementById('feedbackFormCard').style.display = '';
            document.getElementById('feedbackSuccess').classList.remove('show');
            document.querySelectorAll('.fb-error').forEach(el => el.textContent = '');
        }
    </script>
</body>
</html>
