<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @php
        $seoTitle = trim($__env->yieldContent('title', 'Pita Queen - Premium Canadian Cuisine'));
        $seoDescription = trim($__env->yieldContent('meta_description', 'Pita Queen serves authentic Canadian cuisine with premium shawarma, fresh pita, grilled favorites, and fast delivery.'));
        $seoCanonical = trim($__env->yieldContent('canonical', url()->current()));
        $seoImage = trim($__env->yieldContent('og_image', asset('images/logo.png')));
    @endphp
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $seoDescription }}">
    <meta name="keywords" content="pita queen, shawarma, canadian cuisine, fresh pita, authentic middle eastern food, premium restaurant, canadian delivery, best shawarma, grill, kebab, falafel, hummus">
    <meta name="robots" content="@yield('meta_robots', 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1')">
    <meta name="author" content="Pita Queen">
    <link rel="canonical" href="{{ $seoCanonical }}">
    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $seoDescription }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $seoCanonical }}">
    <meta property="og:image" content="{{ $seoImage }}">
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $seoTitle }}">
    <meta name="twitter:description" content="{{ $seoDescription }}">
    <meta name="twitter:image" content="{{ $seoImage }}">
    <title>{{ $seoTitle }}</title>
    
    <!-- Preconnect for performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@@type": "Restaurant",
            "name": "{{ config('app.name') }}",
            "url": "{{ url('/') }}",
            "image": "{{ $seoImage }}",
            "servesCuisine": "Canadian",
            "menu": "{{ route('mobile.menu') }}"
        }
    </script>

    @if (trim($__env->yieldContent('structured_data')) !== '')
        @yield('structured_data')
    @endif
    
    @stack('styles')
</head>
<body>
    <!-- Loader -->
    <div class="page-loader" id="pageLoader">
        <div class="loader-content">
            <div class="loader-logo">
                <img src="/images/logo.png" alt="Pita Queen" style="height: 50px; width: auto;">
                <span class="logo-text">Pita Queen</span>
            </div>
            <div class="loader-spinner"></div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="page-wrapper">
        @if(trim($__env->yieldContent('hide_layout_chrome')) !== '1')
            <x-navbar />
        @endif
        
        <main>
            @yield('content')
        </main>

        @if(trim($__env->yieldContent('hide_layout_chrome')) !== '1')
            <x-footer />
        @endif
    </div>

    @if(trim($__env->yieldContent('hide_layout_chrome')) !== '1')
        <!-- Scroll to Top Button -->
        <button class="scroll-to-top" id="scrollToTop" aria-label="Scroll to top">
            <i class="bi bi-arrow-up"></i>
        </button>
    @endif

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- AOS Animation Library -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    @stack('scripts')
</body>
</html>
