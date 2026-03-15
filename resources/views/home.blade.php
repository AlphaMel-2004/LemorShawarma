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
    <x-hero />

    <!-- About Section -->
    <section class="about-section section-padding" id="about">
        <div class="container">
            <!-- Section Header -->
            <div class="section-header text-center" data-aos="fade-up">
                <span class="section-badge">Our Story</span>
                <h2 class="section-title">About <span class="text-golden">Pita Queen</span></h2>
                <p class="section-description">
                    A legacy of flavor, a tradition of excellence
                </p>
            </div>
            
            <div class="row align-items-center g-5 mt-4">
                <!-- Image Column -->
                <div class="col-lg-6" data-aos="fade-right" data-aos-delay="100">
                    <div class="about-image-wrapper">
                        <div class="about-image about-image-main">
                               <img src="{{ asset('images/lemorfood3.png') }}" 
                                 alt="Our Kitchen" 
                                 loading="lazy"
                                 class="img-fluid">
                        </div>
                        <div class="about-image about-image-secondary">
                            <img src="{{ asset('images/lemorfood4.png') }}" 
                                 alt="Our Chef" 
                                 loading="lazy"
                                 class="img-fluid">
                        </div>
                        
                        <!-- Experience Badge -->
                        <div class="experience-badge">
                            <span class="badge-number">10+</span>
                            <span class="badge-text">Years of Excellence</span>
                        </div>
                    </div>
                </div>
                
                <!-- Content Column -->
                <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                    <div class="about-content">
                        <h3 class="about-subtitle">
                            Crafting Authentic Canadian Flavors Since 2020
                        </h3>
                        
                        <p class="about-text">
                            At Pita Queen, we believe that exceptional food is born from passion, 
                            quality ingredients, and time-honored recipes passed down through generations. 
                            Our master chefs bring the authentic taste of Canadian to every dish.
                        </p>
                        
                        <p class="about-text">
                            From our signature slow-roasted meats to our freshly baked pita and 
                            house-made sauces, every element is crafted with meticulous attention 
                            to detail and an unwavering commitment to excellence.
                        </p>
                        
                        <!-- Features -->
                        <div class="about-features">
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="bi bi-award"></i>
                                </div>
                                <div class="feature-text">
                                    <h4>Premium Quality</h4>
                                    <p>Only the finest ingredients</p>
                                </div>
                            </div>
                            
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="bi bi-heart"></i>
                                </div>
                                <div class="feature-text">
                                    <h4>Made with Love</h4>
                                    <p>Passion in every bite</p>
                                </div>
                            </div>
                            
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="bi bi-flower1"></i>
                                </div>
                                <div class="feature-text">
                                    <h4>Fresh Daily</h4>
                                    <p>Never frozen, always fresh</p>
                                </div>
                            </div>
                            
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="bi bi-star"></i>
                                </div>
                                <div class="feature-text">
                                    <h4>Award Winning</h4>
                                    <p>Recognized excellence</p>
                                </div>
                            </div>
                        </div>
                        
                        <a href="#menu" class="btn btn-golden mt-4">
                            <span>Discover Our Menu</span>
                            <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Decorative Elements -->
        <div class="about-decoration">
            <div class="decoration-circle"></div>
            <div class="decoration-line"></div>
        </div>
    </section>

    <!-- Menu Section -->
    <section class="menu-section section-padding" id="menu">
        <div class="container">
            <!-- Section Header -->
            <div class="section-header text-center" data-aos="fade-up">
                <span class="section-badge">Explore</span>
                <h2 class="section-title">Our <span class="text-golden">Premium Menu</span></h2>
                <p class="section-description">
                    Discover our carefully crafted selection of Canadian delights
                </p>
            </div>
            
            <!-- Filter Tabs -->
            <div class="menu-filters" data-aos="fade-up" data-aos-delay="100">
                <button class="filter-btn active" data-filter="all">
                    <span class="filter-icon"><i class="bi bi-grid-fill" aria-hidden="true"></i></span>
                    <span class="filter-text">All Items</span>
                </button>
                @foreach($menuCategories as $menuCategory)
                    <button class="filter-btn" data-filter="{{ \Illuminate\Support\Str::slug($menuCategory) }}">
                        <span class="filter-text">{{ $menuCategory }}</span>
                    </button>
                @endforeach
            </div>
            
            <!-- Menu Grid -->
            <div class="menu-grid" id="menuGrid">
                @forelse($menuItems as $item)
                    <x-product-card :item="$item" />
                @empty
                    <div class="menu-empty-state" role="status" aria-live="polite">
                        <h3>No menu items available yet.</h3>
                        <p>Please check back soon!</p>
                    </div>
                @endforelse
            </div>
            
            <!-- View More Button -->
            @if($menuItems->isNotEmpty())
                <div class="text-center mt-5" data-aos="fade-up">
                    <a href="#" class="btn btn-outline-golden btn-lg">
                        <span>View Full Menu</span>
                        <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            @endif
        </div>
        
        <!-- Background Decoration -->
        <div class="menu-bg-decoration"></div>
    </section>

    <!-- Best Sellers Section -->
    <section class="bestseller-section section-padding" id="bestseller">
        <div class="container">
            <div class="row align-items-center g-5">
                <!-- Content Column -->
                <div class="col-lg-5" data-aos="fade-right">
                    <div class="bestseller-content">
                        <span class="section-badge">Featured</span>
                        <h2 class="section-title">Our <span class="text-golden">Best Sellers</span></h2>
                        <p class="section-description">
                            These crowd favorites have won the hearts of thousands. 
                            Experience the dishes that made us famous.
                        </p>
                        
                        <div class="bestseller-features">
                            <div class="bs-feature">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Hand-picked premium cuts</span>
                            </div>
                            <div class="bs-feature">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Secret family spice blend</span>
                            </div>
                            <div class="bs-feature">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Slow-roasted to perfection</span>
                            </div>
                            <div class="bs-feature">
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Served fresh daily</span>
                            </div>
                        </div>
                        
                        <a href="#order" class="btn btn-golden btn-lg mt-4">
                            <span>Order Best Sellers</span>
                            <i class="bi bi-bag-check ms-2"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Cards Column -->
                <div class="col-lg-7" data-aos="fade-left" data-aos-delay="100">
                    <div class="bestseller-showcase">
                        @forelse($menuItems->take(3) as $index => $item)
                            <div class="bestseller-card {{ $index === 0 ? 'featured' : '' }}">
                                <div class="bs-card-image">
                                    @php
                                        $bsImageUrl = $item->image
                                            ? (str_starts_with($item->image, 'http') ? $item->image : Storage::url($item->image))
                                                : asset('images/lemorfood1.png');
                                    @endphp
                                    <img src="{{ $bsImageUrl }}"
                                         alt="{{ $item->name }}"
                                         loading="lazy">
                                </div>
                                <div class="bs-card-content">
                                    <h4 class="bs-card-title">{{ $item->name }}</h4>
                                    <p class="bs-card-desc">{{ Str::limit($item->description, 60) }}</p>
                                    <div class="bs-card-footer">
                                        <span class="bs-card-price">${{ number_format($item->price, 2) }}</span>
                                        <div class="bs-card-rating">
                                            <i class="bi bi-star-fill"></i>
                                            <span>4.9</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="menu-empty-state" role="status" aria-live="polite">
                                <h3>No menu items available yet.</h3>
                                <p>Please check back soon!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Background Elements -->
        <div class="bestseller-bg">
            <div class="bg-circle"></div>
            <div class="bg-dots"></div>
        </div>
    </section>

    <!-- Locations Section -->
    <section class="locations-section section-padding" id="locations">
        <div class="container">
            <!-- Section Header -->
            <div class="section-header text-center" data-aos="fade-up">
                <span class="section-badge">Visit Us</span>
                <h2 class="section-title">Our <span class="text-golden">Locations</span></h2>
                <p class="section-description">
                    Find us at these convenient locations across the city
                </p>
            </div>
            
            <!-- Locations Grid -->
            <div class="locations-grid">
                @forelse($locations as $index => $location)
                    <x-location-card :location="$location" data-aos-delay="{{ $index * 100 }}" />
                @empty
                    <div class="locations-empty-state" role="status" aria-live="polite">
                        <h3>No locations available yet.</h3>
                        <p>Please check back soon!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials-section section-padding" id="testimonials">
        <div class="container">
            <!-- Section Header -->
            <div class="section-header text-center" data-aos="fade-up">
                <span class="section-badge">Testimonials</span>
                <h2 class="section-title">What Our <span class="text-golden">Guests Say</span></h2>
                <p class="section-description">
                    Don't just take our word for it — hear from our happy customers
                </p>
            </div>
            
            <!-- Testimonials Slider -->
            <div class="testimonials-slider" data-aos="fade-up" data-aos-delay="100">
                <div class="slider-wrapper" id="testimonialsSlider">
                    @forelse($testimonials as $testimonial)
                        <x-testimonial-card :testimonial="$testimonial" />
                    @empty
                        <div class="testimonials-empty-state" role="status" aria-live="polite">
                            <h3>No feedback yet.</h3>
                            <p>Be the first guest to share your experience.</p>
                        </div>
                    @endforelse
                </div>
                
                <!-- Slider Controls -->
                @if(count($testimonials) > 0)
                    <div class="slider-controls">
                        <button class="slider-btn slider-prev" id="testimonialPrev">
                            <i class="bi bi-arrow-left"></i>
                        </button>
                        <div class="slider-dots" id="testimonialDots"></div>
                        <button class="slider-btn slider-next" id="testimonialNext">
                            <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Background Pattern -->
        <div class="testimonials-pattern"></div>
    </section>

    <!-- Feedback Section -->
    <section class="feedback-section section-padding" id="feedback">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section-header text-center" data-aos="fade-up">
                        <span class="section-badge">Feedback</span>
                        <h2 class="section-title">Share Your <span class="text-golden">Experience</span></h2>
                        <p class="section-description">
                            We'd love to hear your thoughts about our food &amp; service
                        </p>
                    </div>

                    @if(session('feedback_success'))
                        <div class="feedback-success-banner" data-aos="fade-up" role="status">
                            <i class="bi bi-check-circle-fill"></i>
                            <span>{{ session('feedback_success') }}</span>
                        </div>
                    @endif

                    <div class="feedback-form-card" data-aos="fade-up" data-aos-delay="100">
                        <form action="{{ route('home.feedback') }}" method="POST" class="feedback-form">
                            @csrf

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="customer_name" class="feedback-label">Your Name</label>
                                    <input id="customer_name" type="text" name="customer_name" class="feedback-input @error('customer_name') is-invalid @enderror" value="{{ old('customer_name') }}" placeholder="Enter your name" required>
                                    @error('customer_name')
                                        <p class="feedback-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="customer_email" class="feedback-label">Email (optional)</label>
                                    <input id="customer_email" type="email" name="customer_email" class="feedback-input @error('customer_email') is-invalid @enderror" value="{{ old('customer_email') }}" placeholder="your@email.com">
                                    @error('customer_email')
                                        <p class="feedback-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label id="rating-label" class="feedback-label">Rating</label>
                                    <div class="feedback-stars @error('rating') is-invalid @enderror" role="radiogroup" aria-labelledby="rating-label">
                                        @for($rating = 5; $rating >= 1; $rating--)
                                            <input
                                                class="feedback-star-input"
                                                type="radio"
                                                id="rating-{{ $rating }}"
                                                name="rating"
                                                value="{{ $rating }}"
                                                @checked((int) old('rating', 5) === $rating)
                                                required
                                            >
                                            <label class="feedback-star-label" for="rating-{{ $rating }}" aria-label="{{ $rating }} Star{{ $rating > 1 ? 's' : '' }}">
                                                <i class="bi bi-star-fill"></i>
                                            </label>
                                        @endfor
                                    </div>
                                    <p class="feedback-star-hint">Tap a star to rate your experience.</p>
                                    @error('rating')
                                        <p class="feedback-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label for="message" class="feedback-label">Your Feedback</label>
                                    <textarea id="message" name="message" class="feedback-input feedback-textarea @error('message') is-invalid @enderror" placeholder="Tell us about your experience..." maxlength="500" required>{{ old('message') }}</textarea>
                                    @error('message')
                                        <p class="feedback-error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit" class="btn btn-golden mt-4 w-100">
                                <i class="bi bi-send me-2"></i>
                                <span>Submit Feedback</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Order Section -->
    <section class="cta-section" id="order">
        <div class="cta-background">
            <div class="cta-overlay"></div>
            <div class="cta-pattern"></div>
        </div>
        
        <div class="container">
            <div class="cta-content" data-aos="zoom-in">
                <span class="cta-badge">Ready to Order?</span>
                <h2 class="cta-title">
                    Visit Your Nearest <span class="text-golden">Pita Queen</span> Today
                </h2>
                <p class="cta-description">
                    Discover our locations and enjoy premium Canadian cuisine 
                    served fresh daily in-store.
                </p>
                
                <div class="cta-buttons">
                    <a href="#locations" class="btn btn-golden btn-lg">
                        <i class="bi bi-geo-alt me-2"></i>
                        <span>View Locations</span>
                    </a>
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $contactSettings['contact_phone']) }}" class="btn btn-outline-light btn-lg">
                        <i class="bi bi-telephone me-2"></i>
                        <span>Call Us</span>
                    </a>
                </div>
                
                <!-- Delivery Partners -->
                <div class="delivery-partners">
                    <span class="partners-label">Also available on:</span>
                    <div class="partners-logos">
                        <span class="partner-badge">UberEats</span>
                        <span class="partner-badge">DoorDash</span>
                        <span class="partner-badge">Grubhub</span>
                    </div>
                </div>
            </div>
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

@endsection
