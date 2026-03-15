@props(['location'])

@php
    $locationName = data_get($location, 'name');
    $locationAddress = data_get($location, 'address');
    $locationPhone = data_get($location, 'phone');
    $locationHours = data_get($location, 'hours');
    $locationImage = data_get($location, 'image');
    $latitude = data_get($location, 'latitude');
    $longitude = data_get($location, 'longitude');

    $directionQuery = ($latitude !== null && $longitude !== null)
        ? $latitude.','.$longitude
        : urlencode((string) $locationAddress);
@endphp

<div {{ $attributes->merge(['class' => 'location-card']) }} data-aos="fade-up">
    <!-- Card Image -->
    <div class="location-image">
        <img src="{{ $locationImage }}" 
             alt="{{ $locationName }}" 
             loading="lazy"
             class="img-fluid">
        <div class="image-overlay"></div>
    </div>
    
    <!-- Card Content -->
    <div class="location-content">
        <h3 class="location-name">{{ $locationName }}</h3>
        
        <div class="location-details">
            <div class="detail-item">
                <i class="bi bi-geo-alt"></i>
                <span>{{ $locationAddress }}</span>
            </div>
            <div class="detail-item">
                <i class="bi bi-telephone"></i>
                <a href="tel:{{ preg_replace('/[^0-9+]/', '', (string) $locationPhone) }}">{{ $locationPhone }}</a>
            </div>
            <div class="detail-item">
                <i class="bi bi-clock"></i>
                <span>{{ $locationHours }}</span>
            </div>
        </div>
        
        <div class="location-actions">
            <a href="https://www.google.com/maps/search/?api=1&query={{ $directionQuery }}" class="btn btn-golden btn-sm" target="_blank" rel="noopener noreferrer">
                <i class="bi bi-map me-2"></i>Get Directions
            </a>
            <a href="tel:{{ preg_replace('/[^0-9+]/', '', (string) $locationPhone) }}" class="btn btn-outline-golden btn-sm">
                <i class="bi bi-telephone me-2"></i>Call
            </a>
        </div>
    </div>
</div>
