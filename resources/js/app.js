import './bootstrap';

/**
 * Golden Shawarma - Premium JavaScript
 * Handles all interactive features
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all features
    initPageLoader();
    initNavbar();
    initSmoothScroll();
    initScrollToTop();
    initCounterAnimation();
    initMenuFilter();
    initTestimonialsSlider();
    initChatbotWidget();
    initAOS();
});

/**
 * Page Loader
 */
function initPageLoader() {
    const loader = document.getElementById('pageLoader');
    
    if (loader) {
        window.addEventListener('load', function() {
            setTimeout(function() {
                loader.classList.add('loaded');
            }, 500);
        });
        
        // Fallback in case load event doesn't fire
        setTimeout(function() {
            loader.classList.add('loaded');
        }, 3000);
    }
}

/**
 * Navbar Scroll Effect
 */
function initNavbar() {
    const navbar = document.getElementById('mainNavbar');
    const navLinks = document.querySelectorAll('.nav-link');
    const navbarCollapse = document.querySelector('.navbar-collapse');
    
    if (!navbar) return;

    if (navbarCollapse) {
        navbarCollapse.addEventListener('shown.bs.collapse', function() {
            document.body.classList.add('mobile-nav-open');
        });

        navbarCollapse.addEventListener('hidden.bs.collapse', function() {
            document.body.classList.remove('mobile-nav-open');
        });

        document.addEventListener('click', function(event) {
            if (!document.body.classList.contains('mobile-nav-open')) {
                return;
            }

            const clickedInsideDrawer = navbarCollapse.contains(event.target);
            const clickedToggler = event.target.closest('.navbar-toggler');

            if (!clickedInsideDrawer && !clickedToggler) {
                const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse);
                if (bsCollapse) {
                    bsCollapse.hide();
                }
            }
        });
    }
    
    // Scroll effect
    function handleScroll() {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
        
        // Update active link based on scroll position
        updateActiveNavLink();
    }
    
    window.addEventListener('scroll', handleScroll);
    handleScroll(); // Initial check
    
    // Update active nav link based on scroll position
    function updateActiveNavLink() {
        const sections = document.querySelectorAll('section[id]');
        const scrollPosition = window.scrollY + 100;
        
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.offsetHeight;
            const sectionId = section.getAttribute('id');
            
            if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
                navLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === '#' + sectionId) {
                        link.classList.add('active');
                    }
                });
            }
        });
    }
    
    // Close mobile menu on link click
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (navbarCollapse && navbarCollapse.classList.contains('show')) {
                const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse);
                if (bsCollapse) {
                    bsCollapse.hide();
                }
            }
        });
    });
}

/**
 * Smooth Scroll for Anchor Links
 */
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            if (href === '#') return;
            
            e.preventDefault();
            
            const target = document.querySelector(href);
            if (target) {
                const navbarHeight = document.getElementById('mainNavbar')?.offsetHeight || 80;
                const targetPosition = target.offsetTop - navbarHeight;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
}

/**
 * Scroll to Top Button
 */
function initScrollToTop() {
    const scrollBtn = document.getElementById('scrollToTop');
    
    if (!scrollBtn) return;
    
    function toggleScrollBtn() {
        if (window.scrollY > 500) {
            scrollBtn.classList.add('visible');
        } else {
            scrollBtn.classList.remove('visible');
        }
    }
    
    window.addEventListener('scroll', toggleScrollBtn);
    toggleScrollBtn(); // Initial check
    
    scrollBtn.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

/**
 * Counter Animation
 */
function initCounterAnimation() {
    const counters = document.querySelectorAll('[data-count]');
    
    if (counters.length === 0) return;
    
    const animateCounter = (counter) => {
        const target = parseInt(counter.getAttribute('data-count'));
        const duration = 2000;
        const increment = target / (duration / 16);
        let current = 0;
        
        const updateCounter = () => {
            current += increment;
            if (current < target) {
                counter.textContent = Math.floor(current);
                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = target;
            }
        };
        
        updateCounter();
    };
    
    // Use Intersection Observer for triggering animation
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });
    
    counters.forEach(counter => observer.observe(counter));
}

/**
 * Menu Filter
 */
function initMenuFilter() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const menuGrid = document.getElementById('menuGrid');
    
    if (filterBtns.length === 0 || !menuGrid) return;
    
    const cards = menuGrid.querySelectorAll('.product-card');
    
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Update active state
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const filter = this.getAttribute('data-filter');
            
            // Filter cards with animation
            cards.forEach(card => {
                const category = card.getAttribute('data-category');
                
                if (filter === 'all' || category === filter) {
                    card.style.display = 'block';
                    card.style.animation = 'fadeInUp 0.4s ease forwards';
                } else {
                    card.style.animation = 'fadeOutDown 0.3s ease forwards';
                    setTimeout(() => {
                        card.style.display = 'none';
                    }, 300);
                }
            });
        });
    });
    
    // Add filter animations
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes fadeOutDown {
            from {
                opacity: 1;
                transform: translateY(0);
            }
            to {
                opacity: 0;
                transform: translateY(20px);
            }
        }
    `;
    document.head.appendChild(style);
}

/**
 * Testimonials Slider
 */
function initTestimonialsSlider() {
    const slider = document.getElementById('testimonialsSlider');
    const prevBtn = document.getElementById('testimonialPrev');
    const nextBtn = document.getElementById('testimonialNext');
    const dotsContainer = document.getElementById('testimonialDots');
    
    if (!slider || !prevBtn || !nextBtn || !dotsContainer) return;
    
    const cards = slider.querySelectorAll('.testimonial-card');
    const totalCards = cards.length;

    if (totalCards === 0) {
        return;
    }

    let currentIndex = 0;
    let cardsToShow = getCardsToShow();
    let autoplayInterval;

    function getMaxIndex() {
        return Math.max(0, totalCards - cardsToShow);
    }

    function updateControlsVisibility() {
        const shouldShowControls = totalCards > cardsToShow;
        prevBtn.style.display = shouldShowControls ? 'flex' : 'none';
        nextBtn.style.display = shouldShowControls ? 'flex' : 'none';
        dotsContainer.style.display = shouldShowControls ? 'flex' : 'none';
    }
    
    function getCardsToShow() {
        if (window.innerWidth < 768) return 1;
        if (window.innerWidth < 992) return 2;
        return 3;
    }
    
    function createDots() {
        dotsContainer.innerHTML = '';
        const totalDots = Math.max(1, Math.ceil(totalCards / cardsToShow));
        
        for (let i = 0; i < totalDots; i++) {
            const dot = document.createElement('span');
            dot.classList.add('slider-dot');
            if (i === 0) dot.classList.add('active');
            dot.addEventListener('click', () => goToSlide(i));
            dotsContainer.appendChild(dot);
        }
    }
    
    function updateSlider() {
        if (!cards[0]) {
            return;
        }

        const cardWidth = cards[0].offsetWidth + 30; // Including gap
        const offset = currentIndex * cardWidth;
        slider.style.transform = `translateX(-${offset}px)`;
        
        // Update dots
        const dots = dotsContainer.querySelectorAll('.slider-dot');
        dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === Math.floor(currentIndex / cardsToShow));
        });
    }
    
    function nextSlide() {
        const maxIndex = getMaxIndex();
        currentIndex = currentIndex >= maxIndex ? 0 : currentIndex + 1;
        updateSlider();
    }
    
    function prevSlide() {
        const maxIndex = getMaxIndex();
        currentIndex = currentIndex <= 0 ? maxIndex : currentIndex - 1;
        updateSlider();
    }
    
    function goToSlide(dotIndex) {
        currentIndex = dotIndex * cardsToShow;
        const maxIndex = getMaxIndex();
        if (currentIndex > maxIndex) currentIndex = maxIndex;
        updateSlider();
    }
    
    function startAutoplay() {
        if (totalCards <= cardsToShow) {
            return;
        }

        autoplayInterval = setInterval(nextSlide, 5000);
    }
    
    function stopAutoplay() {
        clearInterval(autoplayInterval);
    }
    
    // Event listeners
    nextBtn.addEventListener('click', () => {
        nextSlide();
        stopAutoplay();
        startAutoplay();
    });
    
    prevBtn.addEventListener('click', () => {
        prevSlide();
        stopAutoplay();
        startAutoplay();
    });
    
    // Touch support
    let touchStartX = 0;
    let touchEndX = 0;
    
    slider.addEventListener('touchstart', (e) => {
        touchStartX = e.touches[0].clientX;
        stopAutoplay();
    }, { passive: true });
    
    slider.addEventListener('touchmove', (e) => {
        touchEndX = e.touches[0].clientX;
    }, { passive: true });
    
    slider.addEventListener('touchend', () => {
        const diff = touchStartX - touchEndX;
        if (Math.abs(diff) > 50) {
            if (diff > 0) {
                nextSlide();
            } else {
                prevSlide();
            }
        }
        startAutoplay();
    });
    
    // Hover pause
    slider.addEventListener('mouseenter', stopAutoplay);
    slider.addEventListener('mouseleave', startAutoplay);
    
    // Resize handler
    let resizeTimeout;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(() => {
            cardsToShow = getCardsToShow();
            currentIndex = 0;
            updateControlsVisibility();
            createDots();
            updateSlider();
        }, 200);
    });
    
    // Initialize
    updateControlsVisibility();
    createDots();
    updateSlider();
    startAutoplay();
}

/**
 * Initialize AOS (Animate On Scroll)
 */
function initAOS() {
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            easing: 'ease-out-cubic',
            once: true,
            offset: 50,
            delay: 0,
        });
    }
}

/**
 * Homepage Chatbot Widget
 */
function initChatbotWidget() {
    const widget = document.getElementById('chatbotWidget');
    const panel = document.getElementById('chatbotPanel');
    const toggleBtn = document.getElementById('chatbotToggle');
    const closeBtn = document.getElementById('chatbotClose');
    const form = document.getElementById('chatbotForm');
    const input = document.getElementById('chatbotInput');
    const messages = document.getElementById('chatbotMessages');
    const sendBtn = document.getElementById('chatbotSendBtn');
    const quickPrompts = document.getElementById('chatbotQuickPrompts');
    const scrollTopBtn = document.getElementById('scrollToTop');
    const footerMain = document.querySelector('.footer-main');

    if (!widget || !panel || !toggleBtn || !closeBtn || !form || !input || !messages || !sendBtn) {
        return;
    }

    const assistantName = widget.dataset.name || 'Assistant';
    const welcomeMessage = widget.dataset.welcome || 'Hi! How can I help you today?';

    let typingIndicator = null;
    let hasStartedConversation = false;

    const addMessage = (text, role = 'assistant') => {
        const message = document.createElement('div');
        message.className = `chatbot-message ${role}`;

        const label = document.createElement('span');
        label.className = 'chatbot-message-label';
        label.textContent = role === 'assistant' ? assistantName : 'You';

        const body = document.createElement('p');
        body.className = 'chatbot-message-body';
        body.textContent = text;

        message.appendChild(label);
        message.appendChild(body);
        messages.appendChild(message);

        messages.scrollTop = messages.scrollHeight;

        if (!hasStartedConversation && role === 'user') {
            hasStartedConversation = true;

            if (quickPrompts) {
                quickPrompts.classList.add('is-hidden');
            }
        }
    };

    const showTypingIndicator = () => {
        if (typingIndicator) {
            return;
        }

        const message = document.createElement('div');
        message.className = 'chatbot-message assistant chatbot-thinking';
        message.setAttribute('data-chatbot-thinking', 'true');

        const label = document.createElement('span');
        label.className = 'chatbot-message-label';
        label.textContent = assistantName;

        const body = document.createElement('p');
        body.className = 'chatbot-message-body chatbot-thinking-body';
        body.innerHTML = '<span class="chatbot-thinking-text">Thinking</span><span class="chatbot-thinking-dots" aria-hidden="true"><span></span><span></span><span></span></span>';

        message.appendChild(label);
        message.appendChild(body);
        messages.appendChild(message);
        messages.scrollTop = messages.scrollHeight;

        typingIndicator = message;
    };

    const hideTypingIndicator = () => {
        if (!typingIndicator) {
            return;
        }

        typingIndicator.remove();
        typingIndicator = null;
    };

    const openPanel = () => {
        panel.classList.add('is-open');
        panel.setAttribute('aria-hidden', 'false');
        input.focus();
    };

    const closePanel = () => {
        panel.classList.remove('is-open');
        panel.setAttribute('aria-hidden', 'true');
    };

    const syncWidgetPosition = () => {
        const hasVisibleScrollTop = scrollTopBtn ? scrollTopBtn.classList.contains('visible') : false;
        const footerTop = footerMain ? footerMain.getBoundingClientRect().top : Number.POSITIVE_INFINITY;
        const nearFooter = footerTop < window.innerHeight - 120;

        widget.classList.toggle('with-scroll-top', hasVisibleScrollTop);
        widget.classList.toggle('near-footer', nearFooter);
    };

    if (!messages.hasChildNodes()) {
        addMessage(welcomeMessage, 'assistant');
    }

    toggleBtn.addEventListener('click', () => {
        if (panel.classList.contains('is-open')) {
            closePanel();
            return;
        }

        openPanel();
    });

    closeBtn.addEventListener('click', closePanel);
    window.addEventListener('scroll', syncWidgetPosition, { passive: true });
    window.addEventListener('resize', syncWidgetPosition);

    const submitChatMessage = () => {
        form.dispatchEvent(new Event('submit', { cancelable: true, bubbles: true }));
    };

    if (quickPrompts) {
        quickPrompts.addEventListener('click', (event) => {
            const target = event.target;

            if (!(target instanceof HTMLElement)) {
                return;
            }

            const prompt = target.getAttribute('data-chatbot-quick');

            if (!prompt || input.disabled) {
                return;
            }

            input.value = prompt;
            submitChatMessage();
        });
    }

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const message = input.value.trim();

        if (message.length < 2) {
            return;
        }

        addMessage(message, 'user');
        input.value = '';
        sendBtn.disabled = true;
        input.disabled = true;
        sendBtn.classList.add('is-loading');
        showTypingIndicator();

        try {
            const formData = new FormData(form);
            formData.set('message', message);

            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: formData,
            });

            const payload = await response.json();
            hideTypingIndicator();

            if (!response.ok) {
                addMessage(payload.message || 'The assistant is unavailable right now. Please try again later.', 'assistant');
            } else {
                addMessage(payload.reply || 'Sorry, I could not generate a response right now.', 'assistant');
            }
        } catch (error) {
            hideTypingIndicator();
            addMessage('Network issue detected. Please try again in a moment.', 'assistant');
        } finally {
            sendBtn.disabled = false;
            input.disabled = false;
            sendBtn.classList.remove('is-loading');
            input.focus();
        }
    });

    syncWidgetPosition();
}

/**
 * Lazy Load Images
 */
function initLazyLoad() {
    const lazyImages = document.querySelectorAll('img[loading="lazy"]');
    
    if ('loading' in HTMLImageElement.prototype) {
        // Native lazy loading supported
        return;
    }
    
    // Fallback for browsers that don't support native lazy loading
    const imageObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src || img.src;
                imageObserver.unobserve(img);
            }
        });
    });
    
    lazyImages.forEach(img => imageObserver.observe(img));
}

// Initialize lazy loading
initLazyLoad();

