@extends('layouts.app')

@section('title', 'Our Menu - Pita Queen')

@section('content')
    <!-- Menu Page Hero -->
    <section class="menu-page-hero">
        <div class="container">
            <div class="text-center">
                <span class="section-badge" data-aos="fade-up">Our Menu</span>
                <h1 class="section-title" data-aos="fade-up" data-aos-delay="100">
                    Explore Our <span class="text-golden">Full Menu</span>
                </h1>
                <p class="section-description" data-aos="fade-up" data-aos-delay="200">
                    Discover our complete selection of authentic Mediterranean dishes, crafted with love and premium ingredients.
                </p>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="menu-page-products section-padding">
        <div class="container">
            <!-- Search & Filter Bar -->
            <div class="menu-page-toolbar" data-aos="fade-up">
                <div class="search-box">
                    <i class="bi bi-search"></i>
                    <input type="text" id="menuSearch" placeholder="Search dishes..." class="menu-search-input">
                </div>
                <div class="menu-result-count">
                    <span id="productCount">{{ $products->count() }}</span> items
                </div>
            </div>

            <!-- Products Grid -->
            <div class="menu-grid" id="productsGrid">
                @forelse($products as $item)
                    <x-product-card :item="$item" />
                @empty
                    <div class="text-center py-5 w-100" data-aos="fade-up">
                        <i class="bi bi-basket" style="font-size: 3rem; color: var(--golden);"></i>
                        <h4 class="mt-3" style="color: #fff;">No Products Available</h4>
                        <p style="color: rgba(255,255,255,0.6);">Check back soon for our updated menu.</p>
                    </div>
                @endforelse
            </div>

            <!-- No Results Message (hidden by default) -->
            <div class="text-center py-5 d-none" id="noResults">
                <i class="bi bi-search" style="font-size: 3rem; color: var(--golden);"></i>
                <h4 class="mt-3" style="color: #fff;">No Matching Items</h4>
                <p style="color: rgba(255,255,255,0.6);">Try a different search term.</p>
            </div>

            <!-- Back to Home -->
            <div class="text-center mt-5" data-aos="fade-up">
                <a href="{{ route('home') }}#menu" class="btn btn-outline-golden btn-lg">
                    <i class="bi bi-arrow-left me-2"></i>
                    <span>Back to Home</span>
                </a>
            </div>
        </div>
    </section>
@endsection

@push('styles')
<style>
    .menu-page-hero {
        padding-top: 140px;
        padding-bottom: 40px;
        background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 50%, #0d0d0d 100%);
        position: relative;
    }

    .menu-page-hero::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 80px;
        background: linear-gradient(to bottom, transparent, #0a0a0a);
    }

    .menu-page-products {
        background: #0a0a0a;
    }

    .menu-page-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        margin-bottom: 2.5rem;
        flex-wrap: wrap;
    }

    .search-box {
        position: relative;
        flex: 1;
        max-width: 400px;
    }

    .search-box i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: rgba(255, 255, 255, 0.4);
        font-size: 0.9rem;
    }

    .menu-search-input {
        width: 100%;
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 50px;
        padding: 0.75rem 1rem 0.75rem 2.75rem;
        color: #fff;
        font-family: 'Poppins', sans-serif;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .menu-search-input:focus {
        outline: none;
        border-color: var(--golden);
        box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.15);
        background: rgba(255, 255, 255, 0.08);
    }

    .menu-search-input::placeholder {
        color: rgba(255, 255, 255, 0.35);
    }

    .menu-result-count {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.9rem;
        font-weight: 500;
    }

    .menu-result-count span {
        color: var(--golden);
        font-weight: 700;
    }

    @media (max-width: 575.98px) {
        .menu-page-hero {
            padding-top: 120px;
            padding-bottom: 20px;
        }

        .search-box {
            max-width: 100%;
        }

        .menu-page-toolbar {
            flex-direction: column;
            align-items: stretch;
        }

        .menu-result-count {
            text-align: center;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('menuSearch');
        const grid = document.getElementById('productsGrid');
        const noResults = document.getElementById('noResults');
        const countEl = document.getElementById('productCount');
        const cards = grid.querySelectorAll('.product-card');

        searchInput.addEventListener('input', function () {
            const query = this.value.toLowerCase().trim();
            let visible = 0;

            cards.forEach(function (card) {
                const name = (card.querySelector('.card-title')?.textContent || '').toLowerCase();
                const desc = (card.querySelector('.card-description')?.textContent || '').toLowerCase();
                const match = name.includes(query) || desc.includes(query);

                card.style.display = match ? '' : 'none';
                if (match) visible++;
            });

            countEl.textContent = visible;
            noResults.classList.toggle('d-none', visible > 0);
            grid.classList.toggle('d-none', visible === 0);
        });
    });
</script>
@endpush
