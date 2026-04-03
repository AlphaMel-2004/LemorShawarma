<!-- Navigation Bar -->
<nav class="navbar fixed-top" id="mainNavbar" role="navigation" aria-label="Main navigation">
    <!-- Desktop: three-column centered layout -->
    <div class="nav-desktop d-none d-lg-flex container-fluid px-lg-5">
        <ul class="nav-links nav-links-left" role="list">
            <li><a class="nav-link active" href="{{ route('home') }}#home">HOME</a></li>
            <li><a class="nav-link" href="{{ route('home') }}#menu">MENU</a></li>
        </ul>

        <a class="nav-brand-script" href="{{ route('home') }}#home" aria-label="Pita Queen home">
            Pita Queen
        </a>

        <ul class="nav-links nav-links-right" role="list">
            <li><a class="nav-link" href="{{ route('home') }}#order">ORDER</a></li>
            <li><a class="nav-link" href="{{ route('home') }}#contact">CONTACT</a></li>
        </ul>
    </div>

    <!-- Mobile: brand + toggler -->
    <div class="nav-mobile d-flex d-lg-none container-fluid px-4">
        <a class="nav-brand-script nav-brand-script--mobile" href="{{ route('home') }}#home" aria-label="Pita Queen home">
            Pita Queen
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMobile" aria-controls="navbarMobile" aria-expanded="false" aria-label="Toggle navigation">
            <span class="toggler-icon">
                <span></span>
                <span></span>
                <span></span>
            </span>
        </button>
    </div>

    <!-- Mobile: collapsed menu -->
    <div class="collapse navbar-collapse" id="navbarMobile">
        <ul class="nav-mobile-links">
            <li><a class="nav-link" href="{{ route('home') }}#home">HOME</a></li>
            <li><a class="nav-link" href="{{ route('home') }}#menu">MENU</a></li>
            <li><a class="nav-link" href="{{ route('home') }}#order">ORDER</a></li>
            <li><a class="nav-link" href="{{ route('home') }}#contact">CONTACT</a></li>
        </ul>
    </div>
</nav>
