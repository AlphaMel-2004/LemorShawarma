@extends('layouts.app')

@section('title', 'Pita Queen - Premium Canadian Cuisine')
@section('meta_description', 'Discover Pita Queen, your destination for authentic Canadian cuisine. Enjoy signature shawarma, fresh pita, and handcrafted dishes made with premium ingredients.')
@section('canonical', route('home'))

@section('structured_data')
    <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@@type": "Restaurant",
            "name": "{{ config('app.name') }}",
            "url": "{{ route('home') }}",
            "servesCuisine": "Canadian",
            "menu": "{{ route('mobile.menu') }}",
            "telephone": "{{ $contactSettings['contact_phone'] ?? '' }}",
            "email": "{{ $contactSettings['contact_email'] ?? '' }}",
            "address": {
                "@@type": "PostalAddress",
                "streetAddress": "{{ ($contactSettings['contact_address_line1'] ?? '').' '.($contactSettings['contact_address_line2'] ?? '') }}"
            }
        }
    </script>
@endsection

@section('content')

    <!-- Hero Section -->
    <x-hero :contact-settings="$contactSettings" />

    <!-- Delivery Strip (seam between hero & menu) -->
    <div class="delivery-strip" aria-label="Available on delivery platforms">
        <div class="delivery-strip-track">
            <span class="delivery-strip-label">Order via</span>
            <span class="delivery-strip-badge delivery-strip-badge--skip">
                <img src="{{ asset('images/delivery/skipthedishes.svg') }}" alt="Skip The Dishes" class="delivery-strip-logo">
            </span>
            <span class="delivery-strip-sep">•</span>
            <span class="delivery-strip-badge delivery-strip-badge--doordash">
                <img src="{{ asset('images/delivery/doordash.svg') }}" alt="DoorDash" class="delivery-strip-logo">
            </span>
            <span class="delivery-strip-sep">•</span>
            <span class="delivery-strip-badge delivery-strip-badge--ubereats">
                <img src="{{ asset('images/delivery/ubereats.svg') }}" alt="Uber Eats" class="delivery-strip-logo delivery-strip-logo--ubereats">
            </span>
            {{-- duplicate for seamless loop --}}
            <span class="delivery-strip-sep" aria-hidden="true">•</span>
            <span class="delivery-strip-label" aria-hidden="true">Order via</span>
            <span class="delivery-strip-badge delivery-strip-badge--skip" aria-hidden="true">
                <img src="{{ asset('images/delivery/skipthedishes.svg') }}" alt="" class="delivery-strip-logo">
            </span>
            <span class="delivery-strip-sep" aria-hidden="true">•</span>
            <span class="delivery-strip-badge delivery-strip-badge--doordash" aria-hidden="true">
                <img src="{{ asset('images/delivery/doordash.svg') }}" alt="" class="delivery-strip-logo">
            </span>
            <span class="delivery-strip-sep" aria-hidden="true">•</span>
            <span class="delivery-strip-badge delivery-strip-badge--ubereats" aria-hidden="true">
                <img src="{{ asset('images/delivery/ubereats.svg') }}" alt="" class="delivery-strip-logo delivery-strip-logo--ubereats">
            </span>
        </div>
    </div>

    <!-- Featured Menu Items -->
    <section class="featured-section" id="menu">

        <!-- Section header: title + arrow controls + view all -->
        <div class="featured-section-header">
            <div>
                <h2 class="featured-section-title">Featured Menu</h2>
                <p class="featured-section-sub">Freshly made, always delicious</p>
            </div>
            <div class="featured-header-actions">
                <button class="carousel-arrow-sm" id="featuredPrev" aria-label="Previous">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <button class="carousel-arrow-sm" id="featuredNext" aria-label="Next">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </div>

        <div class="featured-carousel-wrapper">
            <div class="featured-grid" id="featuredGrid">
                @forelse($menuItems->take(3) as $item)
                    @php
                        $featuredImageUrl = $item->image_url;
                    @endphp
                    <article class="featured-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="featured-card-image">
                            <img src="{{ $featuredImageUrl }}"
                                 alt="{{ $item->name }}"
                                 loading="lazy"
                                 class="img-fluid">
                        </div>
                        <div class="featured-card-body">
                            <h3 class="featured-card-title">{{ $item->name }}</h3>
                            @if($item->description)
                                <p class="featured-card-desc">{{ Str::limit($item->description, 55) }}</p>
                            @endif
                            @if(isset($item->price) && $item->price)
                                <span class="featured-card-price">${{ number_format($item->price, 2) }}</span>
                            @endif
                            <a href="#order" class="btn btn-featured-order">Order Now</a>
                        </div>
                    </article>
                @empty
                    <div class="featured-empty" role="status" aria-live="polite">
                        <p>Menu items coming soon.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="carousel-dots" id="featuredDots">
            @forelse($menuItems->take(3) as $item)
                <button class="carousel-dot {{ $loop->first ? 'is-active' : '' }}" data-index="{{ $loop->index }}" aria-label="Go to item {{ $loop->iteration }}"></button>
            @empty
            @endforelse
        </div>

        <div class="featured-view-all-wrap">
            <a href="{{ route('mobile.menu') }}" class="btn-view-full-menu">
                View Full Menu <i class="bi bi-arrow-right"></i>
            </a>
        </div>

    </section>

    <!-- Delivery Partners -->
    <section class="delivery-section" id="order">
        <div class="container">
            <div class="delivery-partners-row">
                <div class="delivery-partner">
                    <img src="{{ asset('images/delivery/skipthedishes.svg') }}" alt="Skip The Dishes" loading="lazy">
                </div>
                <div class="delivery-partner delivery-partner--text delivery-partner--doordash">
                    <span class="delivery-logo-doordash">
                        <svg viewBox="0 0 120 32" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="DoorDash" role="img" height="32">
                            <text x="0" y="26" font-family="Arial,sans-serif" font-size="28" font-weight="800" fill="#FF3008">DoorDash</text>
                        </svg>
                    </span>
                </div>
                <div class="delivery-partner delivery-partner--text delivery-partner--ubereats">
                    <span class="delivery-logo-ubereats">
                        <svg viewBox="0 0 130 32" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Uber Eats" role="img" height="32">
                            <text x="0" y="26" font-family="Arial,sans-serif" font-size="28" font-weight="800" fill="#000">Uber</text>
                            <text x="74" y="26" font-family="Arial,sans-serif" font-size="28" font-weight="800" fill="#06C167">Eats</text>
                        </svg>
                    </span>
                </div>
            </div>
            <p class="delivery-copyright">&copy; {{ date('Y') }} Pita Queen. All Rights Reserved.</p>
        </div>
    </section>

    @if(($chatbotSettings['chatbot_enabled'] ?? '0') === '1')
        @php
            $chatbotFabIconKey = $chatbotSettings['chatbot_fab_icon'] ?? 'chat-dots';
            $chatbotFabIcon = \App\Models\SiteSetting::CHATBOT_FAB_ICON_OPTIONS[$chatbotFabIconKey]['icon'] ?? 'bi-chat-dots-fill';
        @endphp

        <div
            id="chatbotWidget"
            class="chatbot-widget"
            data-endpoint="{{ route('chatbot.reply') }}"
            data-name="{{ $chatbotSettings['chatbot_name'] ?? 'Pita Queen Assistant' }}"
            data-welcome="{{ $chatbotSettings['chatbot_welcome_message'] ?? 'Hi! How can I help you today?' }}"
        >
            <button type="button" class="chatbot-fab" id="chatbotToggle" aria-label="Open assistant chat">
                <span class="chatbot-fab-icon" aria-hidden="true">
                    <i class="bi {{ $chatbotFabIcon }}"></i>
                </span>
                <span class="chatbot-fab-text">Ask AI</span>
            </button>

            <section class="chatbot-panel" id="chatbotPanel" aria-live="polite" aria-hidden="true">
                <header class="chatbot-header">
                    <div>
                        <h3>{{ $chatbotSettings['chatbot_name'] ?? 'Pita Queen Assistant' }}</h3>
                        <p>Menu help, quick suggestions, and store info.</p>
                    </div>
                    <button type="button" class="chatbot-close" id="chatbotClose" aria-label="Close assistant">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </header>

                <div class="chatbot-messages" id="chatbotMessages"></div>

                <div class="chatbot-quick-prompts" id="chatbotQuickPrompts">
                    <button type="button" class="chatbot-quick-btn" data-chatbot-quick="What is your best seller right now?">Best seller</button>
                    <button type="button" class="chatbot-quick-btn" data-chatbot-quick="Can you suggest a combo meal for dinner?">Dinner combo</button>
                    <button type="button" class="chatbot-quick-btn" data-chatbot-quick="What are your opening hours and location?">Hours and location</button>
                </div>

                <form class="chatbot-form" id="chatbotForm" action="{{ route('chatbot.reply') }}" method="POST">
                    @csrf
                    <label for="chatbotInput" class="visually-hidden">Message</label>
                    <input
                        id="chatbotInput"
                        name="message"
                        type="text"
                        class="chatbot-input"
                        placeholder="Ask about menu, locations, or recommendations..."
                        maxlength="500"
                        required
                    >
                    <button type="submit" class="chatbot-send" id="chatbotSendBtn">
                        <i class="bi bi-send-fill"></i>
                    </button>
                </form>
            </section>
        </div>
    @endif

@push('scripts')
<script>
(function () {
    var grid = document.getElementById('featuredGrid');
    var prevBtn = document.getElementById('featuredPrev');
    var nextBtn = document.getElementById('featuredNext');
    var dots = document.querySelectorAll('.carousel-dot');

    if (!grid || !prevBtn || !nextBtn) { return; }

    function getCardWidth() {
        var card = grid.querySelector('.featured-card');
        if (!card) { return 220; }
        return card.offsetWidth + parseInt(getComputedStyle(grid).gap || '16');
    }

    function updateDots() {
        var idx = Math.round(grid.scrollLeft / getCardWidth());
        dots.forEach(function (dot, i) {
            dot.classList.toggle('is-active', i === idx);
        });
    }

    prevBtn.addEventListener('click', function () {
        grid.scrollBy({ left: -getCardWidth(), behavior: 'smooth' });
    });

    nextBtn.addEventListener('click', function () {
        grid.scrollBy({ left: getCardWidth(), behavior: 'smooth' });
    });

    dots.forEach(function (dot) {
        dot.addEventListener('click', function () {
            var idx = parseInt(dot.dataset.index);
            grid.scrollTo({ left: idx * getCardWidth(), behavior: 'smooth' });
        });
    });

    grid.addEventListener('scroll', updateDots);
    updateDots();

    // Auto-advance every 5 seconds
    var totalCards = grid.querySelectorAll('.featured-card').length;
    var autoInterval = setInterval(function () {
        var currentIdx = Math.round(grid.scrollLeft / getCardWidth());
        var nextIdx = (currentIdx + 1) % totalCards;
        grid.scrollTo({ left: nextIdx * getCardWidth(), behavior: 'smooth' });
    }, 5000);

    // Pause auto-advance when user interacts
    grid.addEventListener('touchstart', function () { clearInterval(autoInterval); }, { passive: true });
    prevBtn.addEventListener('click', function () { clearInterval(autoInterval); });
    nextBtn.addEventListener('click', function () { clearInterval(autoInterval); });
})();
</script>
@endpush

@endsection
