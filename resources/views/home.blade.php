@extends('layouts.app')

@section('title', 'Pita Queen Hub - Premium Mediterranean Cuisine')

@section('content')

    <!-- Hero Section -->
    <x-hero />

    <!-- About Section -->
    <section class="about-section section-padding" id="about">
        <div class="container">
            <!-- Section Header -->
            <div class="section-header text-center" data-aos="fade-up">
                <span class="section-badge">Our Story</span>
                <h2 class="section-title">About <span class="text-golden">Pita Queen Hub</span></h2>
                <p class="section-description">
                    A legacy of flavor, a tradition of excellence
                </p>
            </div>
            
            <div class="row align-items-center g-5 mt-4">
                <!-- Image Column -->
                <div class="col-lg-6" data-aos="fade-right" data-aos-delay="100">
                    <div class="about-image-wrapper">
                        <div class="about-image about-image-main">
                            <img src="https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=500" 
                                 alt="Our Kitchen" 
                                 loading="lazy"
                                 class="img-fluid">
                        </div>
                        <div class="about-image about-image-secondary">
                            <img src="https://images.unsplash.com/photo-1544025162-d76694265947?w=300" 
                                 alt="Our Chef" 
                                 loading="lazy"
                                 class="img-fluid">
                        </div>
                        
                        <!-- Experience Badge -->
                        <div class="experience-badge">
                            <span class="badge-number">15+</span>
                            <span class="badge-text">Years of Excellence</span>
                        </div>
                    </div>
                </div>
                
                <!-- Content Column -->
                <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                    <div class="about-content">
                        <h3 class="about-subtitle">
                            Crafting Authentic Mediterranean Flavors Since 2010
                        </h3>
                        
                        <p class="about-text">
                            At Pita Queen Hub, we believe that exceptional food is born from passion, 
                            quality ingredients, and time-honored recipes passed down through generations. 
                            Our master chefs bring the authentic taste of the Mediterranean to every dish.
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
                                    <i class="bi bi-leaf"></i>
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
                    Discover our carefully crafted selection of Mediterranean delights
                </p>
            </div>
            
            <!-- Filter Tabs -->
            <div class="menu-filters" data-aos="fade-up" data-aos-delay="100">
                <button class="filter-btn active" data-filter="all">
                    <span class="filter-icon">🍽️</span>
                    <span class="filter-text">All Items</span>
                </button>
            </div>
            
            <!-- Menu Grid -->
            <div class="menu-grid" id="menuGrid">
                @foreach($menuItems as $item)
                    <x-product-card :item="$item" />
                @endforeach
            </div>
            
            <!-- View More Button -->
            <div class="text-center mt-5" data-aos="fade-up">
                <a href="#" class="btn btn-outline-golden btn-lg">
                    <span>View Full Menu</span>
                    <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
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
                        @foreach($menuItems->take(3) as $index => $item)
                            <div class="bestseller-card {{ $index === 0 ? 'featured' : '' }}">
                                <div class="bs-card-image">
                                    <img src="{{ $item->image ? (str_starts_with($item->image, 'http') ? $item->image : Storage::url($item->image)) : 'https://images.unsplash.com/photo-1529006557810-274b9b2fc783?w=400' }}"
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
                        @endforeach
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
                @foreach($locations as $index => $location)
                    <x-location-card :location="$location" data-aos-delay="{{ $index * 100 }}" />
                @endforeach
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
                    @foreach($testimonials as $testimonial)
                        <x-testimonial-card :testimonial="$testimonial" />
                    @endforeach
                </div>
                
                <!-- Slider Controls -->
                <div class="slider-controls">
                    <button class="slider-btn slider-prev" id="testimonialPrev">
                        <i class="bi bi-arrow-left"></i>
                    </button>
                    <div class="slider-dots" id="testimonialDots"></div>
                    <button class="slider-btn slider-next" id="testimonialNext">
                        <i class="bi bi-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Background Pattern -->
        <div class="testimonials-pattern"></div>
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
                    Experience The <span class="text-golden">Royal Taste</span> Today
                </h2>
                <p class="cta-description">
                    Order online for pickup or delivery and savor the finest Mediterranean 
                    cuisine from the comfort of your home.
                </p>
                
                <div class="cta-buttons">
                    <a href="#" class="btn btn-golden btn-lg">
                        <i class="bi bi-phone me-2"></i>
                        <span>Order Online</span>
                    </a>
                    <a href="tel:+15551234567" class="btn btn-outline-light btn-lg">
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

@endsection
