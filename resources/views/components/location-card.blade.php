@props(['location'])

<div class="location-card" data-aos="fade-up">
    <!-- Card Image -->
    <div class="location-image">
        <img src="{{ $location['image'] }}" 
             alt="{{ $location['name'] }}" 
             loading="lazy"
             class="img-fluid">
        <div class="image-overlay"></div>
    </div>
    
    <!-- Card Content -->
    <div class="location-content">
        <h3 class="location-name">{{ $location['name'] }}</h3>
        
        <div class="location-details">
            <div class="detail-item">
                <i class="bi bi-geo-alt"></i>
                <span>{{ $location['address'] }}</span>
            </div>
            <div class="detail-item">
                <i class="bi bi-telephone"></i>
                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $location['phone']) }}">{{ $location['phone'] }}</a>
            </div>
            <div class="detail-item">
                <i class="bi bi-clock"></i>
                <span>{{ $location['hours'] }}</span>
            </div>
        </div>
        
        <div class="location-actions">
            <a href="{{ $location['map_url'] }}" class="btn btn-golden btn-sm" target="_blank" rel="noopener noreferrer">
                <i class="bi bi-map me-2"></i>Get Directions
            </a>
            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $location['phone']) }}" class="btn btn-outline-golden btn-sm">
                <i class="bi bi-telephone me-2"></i>Call
            </a>
        </div>
    </div>
</div>
