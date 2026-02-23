@props(['item'])

<div class="product-card" data-category="{{ $item['category'] }}" data-aos="fade-up">
    <!-- Card Image -->
    <div class="card-image">
        <img src="{{ $item['image'] }}" 
             alt="{{ $item['name'] }}" 
             loading="lazy"
             class="img-fluid">
        
        <!-- Overlay -->
        <div class="card-overlay">
            <a href="#order" class="btn btn-golden btn-sm">
                <i class="bi bi-bag-plus me-2"></i>Add to Cart
            </a>
        </div>
        
        <!-- Badge -->
        @if($item['badge'])
            <span class="card-badge">{{ $item['badge'] }}</span>
        @endif
        
        <!-- Category Tag -->
        <span class="card-category">{{ ucfirst($item['category']) }}</span>
    </div>
    
    <!-- Card Content -->
    <div class="card-content">
        <h3 class="card-title">{{ $item['name'] }}</h3>
        <p class="card-description">{{ $item['description'] }}</p>
        
        <div class="card-footer">
            <div class="card-price">
                <span class="price-currency">$</span>
                <span class="price-value">{{ number_format($item['price'], 2) }}</span>
            </div>
            
            <div class="card-rating">
                <i class="bi bi-star-fill"></i>
                <span>4.9</span>
            </div>
        </div>
    </div>
</div>
