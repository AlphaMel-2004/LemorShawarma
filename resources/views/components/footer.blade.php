<!-- Footer -->
<footer class="site-footer" id="contact" role="contentinfo" itemscope itemtype="https://schema.org/Restaurant">
    <!-- Footer Top Wave -->
    <div class="footer-wave">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="currentColor"/>
        </svg>
    </div>
    
    <div class="footer-main">
        <div class="container">
            <h2 class="visually-hidden">Footer Information</h2>
            <div class="row g-5">
                <!-- Brand Column -->
                <div class="col-lg-4">
                    <div class="footer-brand">
                        <a href="#home" class="brand-link" itemprop="url" aria-label="Go to top">
                            <img src="/images/logo.png" alt="Pita Queen logo" style="height: 40px; width: auto;" itemprop="logo" loading="lazy">
                            <span class="brand-text">
                                <span class="brand-name" itemprop="name">Pita Queen</span>
                            </span>
                        </a>
                        <p class="brand-description" itemprop="description">
                            Experience the finest Mediterranean cuisine crafted with passion, 
                            premium ingredients, and time-honored recipes since 2010.
                        </p>
                        
                        <!-- Social Links -->
                        <div class="social-links">
                            <a href="#" class="social-link" aria-label="Facebook">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="#" class="social-link" aria-label="Instagram">
                                <i class="bi bi-instagram"></i>
                            </a>
                            <a href="#" class="social-link" aria-label="Twitter">
                                <i class="bi bi-twitter-x"></i>
                            </a>
                            <a href="#" class="social-link" aria-label="TikTok">
                                <i class="bi bi-tiktok"></i>
                            </a>
                            <a href="#" class="social-link" aria-label="YouTube">
                                <i class="bi bi-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div class="col-lg-2 col-md-4">
                    <div class="footer-links">
                        <h4 class="footer-title">Quick Links</h4>
                        <nav aria-label="Quick links">
                            <ul class="link-list">
                                <li><a href="#home">Home</a></li>
                                <li><a href="#about">About Us</a></li>
                                <li><a href="#menu">Our Menu</a></li>
                                <li><a href="#locations">Locations</a></li>
                                <li><a href="#testimonials">Reviews</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                
                <!-- Menu Categories -->
                <div class="col-lg-2 col-md-4">
                    <div class="footer-links">
                        <h4 class="footer-title">Menu</h4>
                        <nav aria-label="Menu links">
                            <ul class="link-list">
                                @forelse($footerMenuCategories as $footerMenuCategory)
                                    <li><a href="#menu">{{ $footerMenuCategory }}</a></li>
                                @empty
                                    <li><a href="#menu">Menu Categories</a></li>
                                @endforelse
                            </ul>
                        </nav>
                    </div>
                </div>
                
                <!-- Contact Info -->
                <div class="col-lg-4 col-md-4">
                    <div class="footer-contact">
                        <h4 class="footer-title">Contact Us</h4>
                        
                        <address class="contact-list" itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="bi bi-geo-alt"></i>
                                </div>
                                <div class="contact-text">
                                    <span itemprop="streetAddress">{{ $contactSettings['contact_address_line1'] }}</span>
                                    <span>{{ $contactSettings['contact_address_line2'] }}</span>
                                </div>
                            </div>
                            
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="bi bi-telephone"></i>
                                </div>
                                <div class="contact-text">
                                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $contactSettings['contact_phone']) }}" itemprop="telephone">{{ $contactSettings['contact_phone'] }}</a>
                                </div>
                            </div>
                            
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="bi bi-envelope"></i>
                                </div>
                                <div class="contact-text">
                                    <a href="mailto:{{ $contactSettings['contact_email'] }}" itemprop="email">{{ $contactSettings['contact_email'] }}</a>
                                </div>
                            </div>
                            
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="bi bi-clock"></i>
                                </div>
                                <div class="contact-text">
                                    <span itemprop="openingHours">{{ $contactSettings['contact_hours'] }}</span>
                                </div>
                            </div>
                        </address>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="copyright">
                        Pita Queen. All Rights Reserved 2026.
                    </p>
                </div>
                <div class="col-md-6">
                    <nav class="footer-bottom-links" aria-label="Legal links">
                        <a href="{{ route('legal.privacy') }}">Privacy Policy</a>
                        <a href="{{ route('legal.terms') }}">Terms of Service</a>
                        <a href="{{ route('legal.cookies') }}">Cookie Policy</a>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</footer>
