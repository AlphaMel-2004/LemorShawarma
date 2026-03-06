<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Pita Queen - Your premier destination for authentic Mediterranean cuisine. Experience expertly crafted shawarma, fresh pita, and premium quality ingredients. Best Mediterranean food restaurant.">
    <meta name="keywords" content="pita queen, shawarma, mediterranean cuisine, fresh pita, authentic middle eastern food, premium restaurant, mediterranean delivery, best shawarma, grill, kebab, falafel, hummus">
    <meta name="robots" content="index, follow">
    <meta name="author" content="Pita Queen">
    <meta property="og:title" content="@yield('title', 'Pita Queen - Premium Mediterranean Cuisine')">
    <meta property="og:description" content="Your premier destination for authentic Mediterranean cuisine. Experience expertly crafted dishes with premium ingredients.">
    <meta property="og:type" content="website">
    <title>@yield('title', 'Pita Queen - Premium Mediterranean Cuisine')</title>
    
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
        <x-navbar />
        
        <main>
            @yield('content')
        </main>
        
        <x-footer />
    </div>

    <!-- Scroll to Top Button -->
    <button class="scroll-to-top" id="scrollToTop" aria-label="Scroll to top">
        <i class="bi bi-arrow-up"></i>
    </button>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- AOS Animation Library -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    @stack('scripts')
</body>
</html>
