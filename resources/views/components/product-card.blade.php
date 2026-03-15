@props(['item'])

@php
    $imageUrl = $item->image
        ? (str_starts_with($item->image, 'http') ? $item->image : Storage::url($item->image))
        : 'https://images.unsplash.com/photo-1529006557810-274b9b2fc783?w=400';
@endphp

<div class="product-card" data-aos="fade-up" data-category="{{ \Illuminate\Support\Str::slug($item->category ?? 'general') }}">
    <!-- Card Image -->
    <div class="card-image">
        <img src="{{ $imageUrl }}"
             alt="{{ $item->name }}"
             loading="lazy"
             class="img-fluid">

        <!-- Overlay -->
        <div class="card-overlay">
            <a href="#order" class="btn btn-golden btn-sm">
                <i class="bi bi-bag-plus me-2"></i>Add to Cart
            </a>
        </div>
    </div>

    <!-- Card Content -->
    <div class="card-content">
        @if(!empty($item->category))
            <span class="card-category">{{ $item->category }}</span>
        @endif
        <h3 class="card-title">{{ $item->name }}</h3>
        <p class="card-description">{{ $item->description }}</p>

        <div class="card-footer">
            <div class="card-price">
                <span class="price-currency">$</span>
                <span class="price-value">{{ number_format($item->price, 2) }}</span>
            </div>

            <div class="card-rating">
                <i class="bi bi-star-fill"></i>
                <span>4.9</span>
            </div>
        </div>
    </div>
</div>
