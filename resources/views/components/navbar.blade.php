<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNavbar">
    <div class="container">
        <div class="navbar-header-shell">
            <!-- Mobile Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="toggler-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </button>

            <!-- Logo -->
            <a class="navbar-brand" href="{{ route('home') }}#home">
                <img src="/images/logo.png" alt="Pita Queen" class="brand-logo" style="height: 40px; width: auto;">
                <span class="brand-text">
                    <span class="brand-name">Pita Queen</span>
                </span>
            </a>
        </div>

        <a href="{{ route('home') }}#order" class="btn btn-sm navbar-mobile-action d-lg-none">
            <i class="bi bi-box-arrow-up-right me-1"></i> Order
        </a>
        
        <!-- Navigation Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('home') }}#home">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}#about">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}#menu">Menu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}#bestseller">Best Sellers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}#locations">Locations</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}#testimonials">Reviews</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}#order">Contact</a>
                </li>
            </ul>
            
            <!-- CTA Button -->
            <div class="navbar-cta ms-lg-4">
                <a href="{{ route('home') }}#order" class="btn btn-golden btn-sm">
                    <i class="bi bi-bag-check me-2"></i>Start Order
                </a>
            </div>
        </div>
    </div>
</nav>
