<!-- Footer -->
<footer class="site-footer" id="contact">
    <!-- Footer Top Wave -->
    <div class="footer-wave">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="currentColor"/>
        </svg>
    </div>
    
    <div class="footer-main">
        <div class="container">
            <div class="row g-5">
                <!-- Brand Column -->
                <div class="col-lg-4">
                    <div class="footer-brand">
                        <a href="#home" class="brand-link">
                            <img src="/images/logo.png" alt="Pita Queen" style="height: 40px; width: auto;">
                            <span class="brand-text">
                                <span class="brand-name">Pita Queen</span>
                            </span>
                        </a>
                        <p class="brand-description">
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
                        <ul class="link-list">
                            <li><a href="#home">Home</a></li>
                            <li><a href="#about">About Us</a></li>
                            <li><a href="#menu">Our Menu</a></li>
                            <li><a href="#locations">Locations</a></li>
                            <li><a href="#testimonials">Reviews</a></li>
                        </ul>
                    </div>
                </div>
                
                <!-- Menu Categories -->
                <div class="col-lg-2 col-md-4">
                    <div class="footer-links">
                        <h4 class="footer-title">Menu</h4>
                        <ul class="link-list">
                            <li><a href="#menu">Signature Items</a></li>
                            <li><a href="#menu">Wraps</a></li>
                            <li><a href="#menu">Platters</a></li>
                            <li><a href="#menu">Bowls</a></li>
                            <li><a href="#menu">Sides & Drinks</a></li>
                        </ul>
                    </div>
                </div>
                
                <!-- Contact Info -->
                <div class="col-lg-4 col-md-4">
                    <div class="footer-contact">
                        <h4 class="footer-title">Contact Us</h4>
                        
                        <div class="contact-list">
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="bi bi-geo-alt"></i>
                                </div>
                                <div class="contact-text">
                                    <span>{{ $contactSettings['contact_address_line1'] }}</span>
                                    <span>{{ $contactSettings['contact_address_line2'] }}</span>
                                </div>
                            </div>
                            
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="bi bi-telephone"></i>
                                </div>
                                <div class="contact-text">
                                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $contactSettings['contact_phone']) }}">{{ $contactSettings['contact_phone'] }}</a>
                                </div>
                            </div>
                            
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="bi bi-envelope"></i>
                                </div>
                                <div class="contact-text">
                                    <a href="mailto:{{ $contactSettings['contact_email'] }}">{{ $contactSettings['contact_email'] }}</a>
                                </div>
                            </div>
                            
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="bi bi-clock"></i>
                                </div>
                                <div class="contact-text">
                                    <span>{{ $contactSettings['contact_hours'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Newsletter -->
            <div class="footer-newsletter">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="newsletter-text">
                            <h4>Subscribe to Our Newsletter</h4>
                            <p>Get exclusive offers, new menu updates, and special promotions delivered to your inbox.</p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <form class="newsletter-form">
                            <div class="input-group">
                                <input type="email" class="form-control" placeholder="Enter your email" required>
                                <button type="submit" class="btn btn-golden">
                                    <span>Subscribe</span>
                                    <i class="bi bi-send ms-2"></i>
                                </button>
                            </div>
                        </form>
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
                        © {{ date('Y') }} Golden Shawarma. All Rights Reserved.
                    </p>
                </div>
                <div class="col-md-6">
                    <div class="footer-bottom-links">
                        <a href="#">Privacy Policy</a>
                        <a href="#">Terms of Service</a>
                        <a href="#">Cookie Policy</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
